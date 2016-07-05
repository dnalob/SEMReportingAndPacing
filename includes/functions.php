<?php
include_once 'psl-config.php';



////////   CREATE SESSION



function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = false;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}



///////// CHECK PASSWORD



function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, val 
        FROM members
        WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $ver);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                
            	//set POST variables
					
				$url = 'https://if-financials-nola-ajjosephjohnson.c9users.io/includes/mail_out_locked.php';
				$fields = array(
				                        'email' => urlencode($email),
				                        'name' => urlencode($username)
				                );

				//url-ify the data for the POST
				$fields_string = '';
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string, '&');

				//open connection
				$ch = curl_init();

				//set the url, number of POST vars, POST data
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

				//execute post
				$result = curl_exec($ch);

				//close connection
				curl_close($ch);
                
                return false;
            }
            else if ($ver == 0){

                return false;

            }
            else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $db_password . $user_browser);
                    // Login successful.

                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");                                    
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}



///////// CHECK EMAIL FOR RECOVER PASSWORD



function check_email($email, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT username 
        FROM members
        WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($username);
        $stmt->fetch();
    
 
        if ($stmt->num_rows == 1) {
            
             // XSS protection as we might print this value
            $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
            
            $token = hash('sha512', uniqid(mt_rand(), true));
            // $expireDate = "NOW() + INTERVAL 1 HOUR";
            
            $insert_stmt = $mysqli->prepare("UPDATE members SET token = ?, expires = NOW() + INTERVAL 24 HOUR WHERE email = ?");
            $insert_stmt->bind_param('ss', $token, $email);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
                exit;
            }
           
           // If user exists send email to user
           
			//set POST variables
			
			$url = '';
			$fields = array(
			                        'email' => urlencode($email),
			                        'name' => urlencode($username),
			                        'token' => urlencode($token)
			                );

			//url-ify the data for the POST
			$fields_string = '';
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
           
           // Email lookup successful.
            return true;
           
        } else {
            // No user exists.
            return false;
        }
    }
}



///////////     LOG LOGIN ATTEMPTS



function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 10) {
            return true;
        } else {
            return false;
        }
    }
}



//////////    BUILD HASH_EQUALS FUNCTION



if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}



//////////    CHECK LOGIN STATUS



function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password, val 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password, $ver);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ((hash_equals($login_check, $login_string)) && ($ver == 1)){
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}



//////////    FIND EMAIL FUNCTION



function find_email($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT email 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($sessionEmail);
                $stmt->fetch();
                return $sessionEmail;
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}



//////////    CHECK TOKEN STATUS



function token_check($mysqli, &$email, &$token) {
    // Check if all session variables are set 
    if (isset($_GET['token'])) {
 
        $token = $_GET['token'];
 
        // // Get the user-agent string of the user.
        // $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $blank = "";
        $expire_stmt = $mysqli->prepare("UPDATE members SET token = ? WHERE expires < NOW()");
        $expire_stmt->bind_param('s', $blank);
        $expire_stmt->execute();
 
        if ($stmt = $mysqli->prepare("SELECT email 
                                      FROM members 
                                      WHERE token = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 

            $stmt->bind_param('s', $token);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($email);
                $stmt->fetch();
 
                return true;
                // return $email;
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}



//////////    CHECK TOKEN STATUS



function token_val_check($mysqli, &$token, &$name) {
    // Check if all session variables are set 
    if (isset($_GET['token'])) {
 
        $token = $_GET['token'];

        // // Get the user-agent string of the user.
        // $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $blank = "";
        $expire_stmt = $mysqli->prepare("UPDATE members SET tokenVal = ? WHERE expiresVal < NOW()");
        $expire_stmt->bind_param('s', $blank);
        $expire_stmt->execute();
 
        if ($stmt = $mysqli->prepare("SELECT username 
                                      FROM members 
                                      WHERE tokenVal = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 

            $stmt->bind_param('s', $token);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
               
                // If the user exists get variables from result.
                $stmt->bind_result($name);
                $stmt->fetch();

                $verBool = 1;
                $expire_stmt = $mysqli->prepare("UPDATE members SET val = ? WHERE tokenVal = ? LIMIT 1");
                $expire_stmt->bind_param('is', $verBool, $token);
                $expire_stmt->execute();
 
                return true;
                // return $email;
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}



//////////      SANITIZE URL



function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
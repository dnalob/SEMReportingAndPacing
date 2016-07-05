<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';
 

$error_msg = "";


if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $allowed = array('');
    $explodedEmail = explode('@', $email);
    $domain = array_pop($explodedEmail);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="alert alert-danger">The email address you entered is not valid</p>';
    }
    else if ( ! in_array($domain, $allowed) ) {
        $error_msg .= '<p class="alert alert-danger">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="alert alert-danger">Invalid password configuration.</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="alert alert-danger">A user with this email address already exists.</p>';
                        $stmt->close();
        }
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg)) {
 
        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);
 
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password) VALUES (?, ?, ?)")) {
            $insert_stmt->bind_param('sss', $username, $email, $password);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }

        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);

// Generate token and insert into DB

        $token = hash('sha512', uniqid(mt_rand(), true));
        // $blank = '';
        // $expireDate = "NOW() + INTERVAL 1 HOUR";
        
        $insert_stmt = $mysqli->prepare("UPDATE members SET tokenVal = ?, expiresVal = NOW() + INTERVAL 1 WEEK WHERE email = ?");
        $insert_stmt->bind_param('ss', $token, $email);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
            header('Location: ../error.php?err=Registration failure: INSERT');
            exit;
        }

// Send verification email to user
                        
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
                  
 // Sent email success 

        header('Location: ../login.php?emailver=1');

    }
}

?>
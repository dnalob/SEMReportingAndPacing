<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";
 
if (isset($_POST['p'], $_POST['token'])) {
    
    // // Sanitize and validate the data passed in
    // $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     // Not a valid email
    //     $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    // }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (strlen($token) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid token configuration.</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg)) {
 
        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = $_POST['token']; 
 
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("UPDATE members SET password = ? WHERE token = ?")) {
            $insert_stmt->bind_param('ss', $password, $token);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Reset password failure: INSERT');
            }
        }
        header('Location: ../login.php?pass=1');
    }
}

?>
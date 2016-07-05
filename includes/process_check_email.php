<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'])) {
    $email = $_POST['email'];
 
    if (check_email($email, $mysqli) == true) {
        // Login success 
        header('Location: ../find_email.php?success=1');
    } else {
        
        header('Location: ../find_email.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
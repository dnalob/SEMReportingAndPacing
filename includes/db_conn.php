<?php include_once 'psl-config.php';

$conn = new mysqli(HOST, USER, PASSWORD, '');
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
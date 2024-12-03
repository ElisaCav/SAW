<?php
session_start();
// Disable any error output that could corrupt JSON response
ini_set('display_errors', 0);
error_reporting(0);
require "../db/mysql_credentials.php";
require "dbconnections.php";

header('Content-Type: application/json');

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email']; 
    // check if there is already 1 occurrence of the email address in the database
    $query = 'SELECT 1 FROM `user` WHERE `email` = ? LIMIT 1';  
    $result = fetch_single_result($con,$query,'s',$email); 
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'found data']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'not found data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No email provided']);
}
exit();
?>
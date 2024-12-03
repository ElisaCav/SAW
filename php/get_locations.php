<?php
session_start();
ini_set('log_errors', 0);	
ini_set('error_log', '../logs/get_locations.log');
require_once "../db/mysql_credentials.php";
require_once "dbconnections.php";

$query = 'SELECT locationid, name, address, owner, phone, description, availability, capacity, audio, catering, price, type, photo  FROM `location` WHERE availability=true;';
$data = fetch_values_no_params($con, $query);

error_log('data: '. print_r($data, true));

header('Content-Type: application/json');
echo json_encode($data); 

?>
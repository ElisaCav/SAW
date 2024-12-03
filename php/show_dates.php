<?php

if (!isset($_GET['location_id'])) {
    die(json_encode(['error' => 'location_id is required']));
}
$location_id = $_GET['location_id'];

header('Content-Type: application/json');

require_once "../db/mysql_credentials.php";
require_once "dbconnections.php";

//find the dates where the location is already booked
$query = "SELECT starttime, endtime FROM booking WHERE locationid = ?";
$booked_dates = fetch_multiple_results($con, $query,'i',$location_id);

echo json_encode($booked_dates);
?>
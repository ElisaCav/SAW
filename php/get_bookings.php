<?php
session_start();

require_once ('../db/mysql_credentials.php');
require_once ('../php/dbconnections.php');

$userId = $_SESSION['userid'];

global $con;
$bookings = array();

$query = "SELECT 
    bookingid,
    location.name,
    DATE_FORMAT(starttime, '%d/%m/%Y %H:%i') as starttime,
    DATE_FORMAT(endtime, '%d/%m/%Y %H:%i') as endtime,
    duration,
    cancellation,
    DATE_FORMAT(requesttime, '%d/%m/%Y %H:%i') as requesttime,
    totalprice
    FROM `booking`
    JOIN `location` ON location.locationid = booking.locationid
    WHERE user = ?";
  
$bookings=fetch_multiple_results($con, $query, 'i', $userId);

// Return bookings as JSON
header('Content-Type: application/json');
echo json_encode($bookings);
?>
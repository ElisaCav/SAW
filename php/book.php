<?php	
session_start();
ini_set('log_errors', 0);
ini_set('display_errors', 0);
error_reporting(0); // set to 0 for production
//ini_set('error_log', '../../logs/books.log');

require "../db/mysql_credentials.php";
require "../php/dbconnections.php";

// get session variable 'userid'
$userId = $_SESSION['userid'] ?? null;

/*
Returns true if the location is available.
The query is selecting bookings that have not been canceled and
whose starttime and duration cause them to overlap with a specified time range, checking for:
- bookings that start before or at a given time and end after it;
- bookings that start before another time but end at or after it;
- bookings that start and end completely within a given time range.
*/
function verifyAvailability($locationid, $starttime, $endtime, $con) {
    $query = "SELECT bookingid FROM booking WHERE locationid=? AND cancellation=false AND (
        (starttime <= ? AND DATE_ADD(starttime, INTERVAL duration HOUR) > ?) OR
        (starttime < ? AND DATE_ADD(starttime, INTERVAL duration HOUR) >= ?) OR
        (starttime >= ? AND DATE_ADD(starttime, INTERVAL duration HOUR) <= ?)
    )";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'issssss', $locationid, $starttime, $starttime, $endtime, $endtime, $starttime, $endtime);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0 ? false : true;
}

function checkTotalPrice($con, $place,$duration){
    $query = "SELECT price FROM `location` WHERE locationid = ?";
    $row = fetch_single_result($con,$query,"s", $place);
    $amount = (float) $row['price'];
    return $amount*(float)$duration;
}

// Function to book an appointment
function book($place, $dateTime, $duration, $price, $user) {
    global $con;
    $response = [
        'status' => '',
        'message' => ''
    ];

    if (isset($place, $dateTime, $duration)) {
        $endDateTime = getEndTime($dateTime, $duration);
       // error_log("VARIABLES: ".$place.", ".$dateTime.", ".$duration.", ".$price.", ".$user);
        mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);
        try {
            $isAvailable = verifyAvailability($place, $dateTime, $endDateTime, $con);
            if (!$isAvailable) {
                mysqli_rollback($con);
                $response['status'] = 'error';
                $response['message'] = "La stanza ".htmlspecialchars($place, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1')." non è al momento disponibile";
                return $response;
            }

            $total = checkTotalPrice($con, $place,$duration);
         
            $query = "INSERT INTO booking (locationid, starttime, endtime, duration, user, totalprice) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt=mysqli_stmt_init($con);
            execute_prepared_statement($stmt,$query,$result,'issiii', [$place, $dateTime, $endDateTime, $duration, $user, $total]);
            mysqli_commit($con);
            error_log("VARIABLES BOOK: ".$place.", ".$dateTime.", ".$duration.", ".$price.", ".$user);
            $response['status'] = 'success';
            $response['message'] = htmlspecialchars($place, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
            return $response;
        } catch (Exception $e) {
            mysqli_rollback($con);
            $response['status'] = 'error';
            $response['message'] = "Error rollback: " . $e->getMessage();
            return $response;
        }
    }
}

// Function to book all bookings in the cart
function bookAll($cart) {

    $results = array();

    foreach ($cart as $booking) {
        $place = $booking['place'];
        $dateTime = $booking['bookdatetime'];
        $duration = $booking['duration'];
        $price = $booking['totalprice'];
        $user = $_SESSION['userid'];
        error_log("VARIABLES: ".$place.", ".$dateTime.", ".$duration.", ".$price.", ".$user);
        $result = book($place, $dateTime, $duration, $price, $user);
        $results[] = $result;
    }

    return $results;
}

function getEndTime($dateTime, $duration) {
   return date('Y-m-d H:i:s', strtotime($dateTime . ' +' . $duration . ' hours'));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//ob_start();
// When using JSON content-type the $_POST array will not populate

    header('Content-Type: application/json');

    $_POST = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $response = [
            'status' => '',
            'message' => ''
        ];

        if ($action !== 'check' && !isset($_SESSION['userid'])) {
            $response['status'] = 'error';
            $response['message'] = "Effettua il login per acquistare";
            echo json_encode($response);
            error_log("User not logged in");
        } else {
            switch ($action) {
                case 'buy':
                    if (isset($_POST['place'], $_POST['bookdatetime'], $_POST['duration'], $_POST['totalprice'])) {
                        $place = $_POST['place'];
                        $dateTime = $_POST['bookdatetime'];
                        $duration = $_POST['duration'];
                        $price = $_POST['totalprice'];
                        $user = $_SESSION['userid'];
                        error_log("VARIABLES: ".$place.", ".$dateTime.", ".$duration.", ".$price.", ".$user);
                        $result = book($place, $dateTime, $duration, $price, $user);
                        echo json_encode($result);
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = "Dati non validi per la prenotazione";
                        echo json_encode($response);
                        exit();
                    }
                    break;
                case 'buyAll':
                    if (isset($_POST['cart'])) {
                        $cart = json_decode($_POST['cart'], true);
                        error_log("CART:" . print_r($cart, true));
                        $results = bookAll($cart);
                        echo json_encode($results);
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = "Non ci sono elementi validi nel carrello";
                        echo json_encode($response);
                        exit();
                    }
                    break;
                case 'check':
                    if (isset($_POST['place'], $_POST['bookdatetime'], $_POST['duration'])) {
                        $place = $_POST['place'];
                        $dateTime = $_POST['bookdatetime'];
                        $duration = $_POST['duration'];
                        $endDateTime = getEndTime($dateTime, $duration);
                      //  error_log("endDateTime". $endDateTime."\n");
                        $available = verifyAvailability($place, $dateTime, $endDateTime, $con);
                        //error_log("available". $available. "\n");
                        echo json_encode(array("available" => $available));
                    } else {
                        http_response_code(400); // 400 Bad Request
                        $response['status'] = 'error';
                        $response['message'] = "Dati non validi per il controllo disponibilità";
                        echo json_encode($response);
                    }
                    break;
               
                default:
                    $response['status'] = 'error';
                    $response['message'] = "Azione non valida";
                    echo json_encode($response);
                    break;
            }
        }
    }

}
mysqli_close($con);


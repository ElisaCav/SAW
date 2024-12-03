<?php
session_start();

require_once "../php/dbconnections.php";
require "../db/mysql_credentials.php";
ini_set('log_errors', 1);    
ini_set('error_log', '../../logs/login.log');
error_reporting(E_ALL);

function generateUniqueToken() {
    return bin2hex(random_bytes(8));
}

error_log("Login: ");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST["submit"]) && !empty($_POST['submit'])) {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $pass = $_POST['pass']; 
            if (empty($pass) || empty($email)) {
                throw new Exception("Pass or email data missing in login POST");
            }
            //RFC 3696, section 3
            if(strlen($email)>320) {
                throw new Exception("email address is too long");
            }

            $query = 'SELECT userid, email, pass, firstname FROM `user` WHERE email = ?;';
            $row = fetch_single_result($con, $query, 's', $email);
            if ($row) {
                $dbpass = $row["pass"];
                error_log("DB pass: " . print_r($dbpass, true) . ".\n");

                if (!password_verify($pass, $dbpass)) {
                    throw new Exception("Password verification failed.");
                }

                $_SESSION['userid'] = $row['userid']; 

                if (isset($_POST["remember_me"])) {
                    error_log('$_POST["remember_me"]'.$_POST["remember_me"]);
                    $token = generateUniqueToken();
                    error_log("token: ".$token);
                    print_r($token);

                    $expiresAt = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)); // 30 days validity

                    $query = "UPDATE user SET cookieid = ?, cookieexpiration = ?, cookieflag = true WHERE userid = ?";
                    $params = array($token, $expiresAt, $_SESSION['userid']);

                    error_log(print_r($params, true));
                    $types = "ssi";
                    error_log("TYPES:" . $types);
                    update_table($con, $query, $types,$params);
    
                    // TODO in localhost secure must be false, on the server set to true
                    setcookie('remember_me', $token, strtotime($expiresAt), '/', '', true, true); 

                }
                header('Location: show_profile.php');
                exit();
            } else {
                error_log("incorrect mail or password");
                throw new Exception("Incorrect email or password.");
            }
        } else {
            error_log("Missing values in POST");
            throw new Exception("Missing values in POST");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo('<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
		<div style="text-align: center; font-family: \"Lato\", sans-serif; background-color: #fff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
			<h1>Credenziali errate. </h1>
			<p>Verrai reindirizzato alla pagina di login in 5 secondi.</p>
		</div>
	  </div>');
      header('Refresh:5; url=login_form.php');
    }
} else {
    error_log("Method is not POST.");
    echo "Metodo di richiesta non supportato.";
}

?>

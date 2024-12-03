<?php
session_start();
ini_set('log_errors', 1);    
ini_set('error_log', '../logs/registration.log');

require "../db/mysql_credentials.php";
require "../php/dbconnections.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_POST["submit"])) {
            throw new Exception("Session variable 'submit' not set");
        }

        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $email = trim($_POST["email"]);
        $pass = trim($_POST["pass"]);
        $confirm = trim($_POST["confirm"]); // confirm-password

        if (empty($firstname) || strlen($firstname)>50 || !(preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/', $firstname))) {
            throw new Exception("Not a valid name: $firstname");
        }

        if (empty($lastname) || strlen($lastname)>50 || !(preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/', $lastname))) {
            throw new Exception("Not a valid surname: $lastname");
        }

        if (!empty($email)) {
            if (strlen($email)>316 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format: $email");
            }
        } else {
            throw new Exception("Email is empty");
        }

        if (!empty($pass)) {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            if (!password_verify($confirm, $hashedPass)) {
                throw new Exception("Password verification failed: passwords do not match");
            }

            try {
                // SELECT 1 returns a set with single column with the value 1 for each row that satisfies the condition in the WHERE clause
                // check if there is any value in the table, returns the empty set if not (fetch_assoc() returns null)
                $select_query = 'SELECT 1 FROM `user` WHERE email=?;';
                $select_result = fetch_single_result($con, $select_query, 's', $email);
                if (empty($select_result)) {
                    $query = 'INSERT INTO `user` (firstname, lastname, email, pass) VALUES (?, ?, ?, ?);';
                    $params = [$firstname, $lastname, $email, $hashedPass];
                    $params_types = 'ssss';
                    update_table($con, $query, $params_types, $params);
                    mysqli_close($con);
                    echo '<script>alert("Registrazione effettuata con successo");</script>';
                    header('Refresh:5; url=login_form.php');
                    exit();
                } else {
                    throw new Exception("Email already exists in the database");
                }
            } catch (Exception $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        } else {
            throw new Exception("Password is empty");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Si è verificato un errore. Riprova più tardi.";
        header('Refresh:15; url=home.php');
        exit();
    }
}
?>
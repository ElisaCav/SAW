<?php
require_once "../db/mysql_credentials.php";
require_once "dbconnections.php";
ini_set('log_errors', 1);
ini_set('error_log', '../logs/auth.log');

// Function to clear the "Remember Me" cookie and its associated data in the database for the logout operation
function clearRememberMeCookie($con, $rememberToken) {
    $updateQuery = "UPDATE user SET cookieid=NULL, cookieexpiration=NULL, cookieflag=0 WHERE cookieid = ?";
    $updateStmt = mysqli_stmt_init($con);
    execute_prepared_statement($updateStmt, $updateQuery, $result, 's', $rememberToken);
    setcookie('remember_me', '', time() - 3600*3, '/'); 
}

// Function to check if the "Remember Me" cookie is valid, and if so, start the user's session
function checkRememberMeCookie($con) {
    if (!isset($_COOKIE['remember_me'])) {
        error_log('Remember me cookie not set');
        return false;
    }

    $tokenToCheck = $_COOKIE['remember_me'];
    error_log('Remember me cookie found: ' . $tokenToCheck);

    $query = "SELECT userid, cookieexpiration FROM user WHERE cookieid = ?";
    $stmt = mysqli_stmt_init($con);
    error_log("Created statement");

    execute_prepared_statement($stmt, $query, $result, 's', $tokenToCheck);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount === 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['userid'];
        $expiresAt = $row['cookieexpiration'];

        error_log('User ID: ' . $userId . ' Expires At: ' . $expiresAt);

        if (strtotime($expiresAt) > time()) {
            $_SESSION['userid'] = $userId;
            error_log("Found valid cookie");
            mysqli_stmt_close($stmt);
            return true;
        } else {
            error_log("Cookie expired");
        }
    } else {
        error_log("No matching rows found");
    }
    mysqli_stmt_close($stmt);
    return false;
}

// Function to check if the user is authenticated (via session or "Remember Me" cookie)
function isAuthenticated($con) {
    

    if (isset($_SESSION['userid'])) {
        error_log("User is logged in with ID: " . $_SESSION['userid']);
        return true;
    }

    if (checkRememberMeCookie($con)) {
        error_log("User logged in via 'Remember Me' cookie");
        error_log(($_SESSION['userid']));
        return true;
    }

    error_log("User not authenticated");
    return false;
}

// Function to deny access to a private (reserved) page if user is not authenticated
function denyUnauthenticatedAccess($con) {
    if (!isAuthenticated($con)) {
        error_log("Access denied: User not authenticated, redirecting to login");
        header("Location: ../content/login_form.php");
        exit();
    }
}
?>

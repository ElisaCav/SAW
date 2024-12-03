<?php
    require_once "../db/mysql_credentials.php";
    require_once "dbconnections.php";
    require_once "../php/auth.php";
    ini_set('log_errors', 1);	
    ini_set('error_log', '../logs/reserved_page.log');

    error_log("session info stored in: " . ini_get('session.save_path'));

       // if the cookie is in the HTTP request, it will be stored in superglobal array $_COOKIE
    if(isset($_COOKIE['remember_me'])) {
        //if the cookie is set the function checkRememberMeCookie starts the user's session 
        if(!checkRememberMeCookie($con)){
            error_log("cookie set but not valid");
            header("Refresh:8; url= ../content/login_form.php");
            exit();
        }
    }

    // check the session variable
    if(!isset($_SESSION["userid"])) {
        error_log("Session variable 'userid' not set");
        session_unset();
        session_destroy();
        header("Refresh:8; url= ../content/login_form.php");
        exit();
    }

?>
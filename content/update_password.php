<?php 
  	session_start();
	require_once '../php/auth.php';
	denyUnauthenticatedAccess($con);
  

	require_once "../db/mysql_credentials.php";
	require_once "../php/dbconnections.php";

	ini_set('log_errors', 1);	
	ini_set('error_log', '../../logs/update_password.log');
	
	$select_query = "SELECT pass FROM `user` WHERE userid=?";
	$select_params = $_SESSION['userid'];
	$row = fetch_single_result($con, $select_query,'s', $select_params);

	if(!empty($row['pass'])) {
		if(password_verify($_POST['oldpwd'],$row['pass'])){
			$newpassword = password_hash($_POST['newpwd'], PASSWORD_DEFAULT);
			$update_params=[$newpassword,$_SESSION['userid']];
			$update_query = "UPDATE `user` SET pass = ? WHERE userid = ?";
			update_table($con, $update_query,'si', $update_params);
			echo 'Password aggiornata con successo.';
			header('Refresh:5; url=show_profile.php');
		}else{
            echo 'Si è verificato un problema nell\'aggiornamento della password';
			header('Refresh:5; url=update_password_form.php');
			
        }
	}
    else{
        error_log('cannot get old password from database');
    }
?>
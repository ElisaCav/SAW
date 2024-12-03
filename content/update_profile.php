<?php 
	session_start();
	ini_set('log_errors', 1);	
	ini_set('error_log', '../../logs/update_profile.log');
	require_once ("../php/auth.php");
	denyUnauthenticatedAccess($con);
	

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if(!isset($_POST["submit"])) {
			header('Refresh:5; url=login_form.php');
			exit(); //terminate the current script
		}
		
		if(isset($_POST["firstname"], $_POST["lastname"])){
			$firstname = trim($_POST["firstname"]);
			$lastname= trim($_POST["lastname"]);
			if(!empty($firstname)&&!empty($lastname)){

				if(strlen($firstname)>50 || strlen($lastname)>50){
					echo "Dati non validi. Inserire nuovamente i dati da aggiornare";
					header('Refresh:5; url=update_profile_form.php');
				}
		
				#connect to database
				require_once "../db/mysql_credentials.php";
				require_once "../php/dbconnections.php";

				$query = 'UPDATE `user` SET firstname = ?, lastname = ? WHERE userid = ?;';
				$types='sss';
				$params=[$firstname,$lastname,$_SESSION["userid"]];
				#update query with prepared statement (dbconnections.php)
				update_table($con,$query,$types,$params);
				#close db connection
				mysqli_close($con);
				echo "I dati sono stati aggiornati";
				header('Refresh:5; url=show_profile.php');
			}
			else {
				echo "Inserire i dati da aggiornare";
				header('Refresh:5; url=update_profile_form.php');
			}
		}
		else {
			echo "Inserire i dati da aggiornare";
			header('Refresh:5; url=update_profile_form.php');
		}
	}
?>
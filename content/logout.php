<?php
	session_start();
	ini_set('log_errors', 1);	
	ini_set('error_log', '../../logs/logout.log');
	require_once('../php/auth.php');
	
	if(isset($_SESSION['userid'])){
	
		# delete "Remember Me" cookie from browser and database
		if (isset($_COOKIE['remember_me'])) {
			try {
				clearRememberMeCookie($con, $_COOKIE['remember_me']);
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				throw $e;
			}
		}

		# delete session variables
		$_SESSION = []; 
		# delete the session cookie 
		if (ini_get("session.use_cookies")) { 
			$params = session_get_cookie_params(); 
			setcookie(session_name(), '', time() - 42000, 
				$params["path"], $params["domain"], 
				$params["secure"], $params["httponly"] 
			); 
		} 
		# destroy the session
		session_destroy();

		echo('<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
		<div style="text-align: center; font-family: \"Lato\", sans-serif; background-color: #fff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
			<h1>Log out avvenuto con successo</h1>
			<p>Verrai reindirizzato alla home page tra 5 secondi.</p>
		</div>
	  </div>');	
	}	
	
	else error_log("session variable not found");	

	header('Refresh:5; url=../content/home.php');
?>

<?php
	ini_set('log_errors', 1);	
	ini_set('error_log', '../logs/registration_form	.log');
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<?php 
		include "common/common_head.php";
	?>
    <link  href="../style/form_style.css" rel="stylesheet" type="text/css">
    <title>Sign-up</title>
</head>
<body id="formbody">
<header></header>
     <div class="row justify-content-center">
		<div class="form-container" id="my-form-container">
				<div class="container text-center">
					<img src="../images/logo1.png" width="150" height="150" alt="logo" >
				</div>		
			<form id="registrationForm" action="registration.php" method="post" onsubmit= "return validateRegistrationForm();"> 
				<fieldset>
					<legend class="text-center mb-3 p-3">Registrazione</legend>
					<div class="mb-3 p-3">
						<div class="mb-3 p-3" id="reg_form_div">
							<label for="firstname" class="mt-1 mb-1">Nome</label>
							<input class="form-control input-sm pull-right mb-1" type="text" id="firstname" name="firstname" placeholder="nome" autocomplete="off" required>
							<span id="firstname_error" style='color: red;'></span><br>
				
							<label for="lastname" class="mt-1 mb-1">Cognome</label>
							<input class="form-control input-sm pull-right mb-1" type="text" id="lastname" name="lastname" placeholder="cognome" autocomplete="off" required>
							<span id="lastname_error" style='color: red;'></span><br>	
						
							<label for="email" class="mt-1 mb-1">Email</label>
							
							<input class="form-control input-sm pull-right mb-1" type="email" id="email" name="email" required onchange="return emailExists();" placeholder="email" autocomplete="off">
							<span id="email_error" style='color: red;'></span><br>
						
							<label for ="pass" class="mt-1 mb-1">Password</label>
							<input class="form-control input-sm pull-right mb-1" type="password" id="pass" name="pass" placeholder="password" autocomplete="off" required>
							<span id="pwd_error" style='color: red;'></span><br>
						
							<label for="confirm" class="mt-1 mb-1">Conferma password</label>
							<input class="form-control input-sm pull-right mb1" type="password" id="confirm" name="confirm" placeholder="conferma password" autocomplete="off" required>
							<span id="confirm_error" style='color: red;'></span><br>	
						</div>	
					</div>
					<div class="mb-3 px-3 text-center">
						<input class="btn btn-primary" type="submit" id="submit" name="submit" value="Conferma">
						<input class="btn btn-primary" type="button" id="cancel" name="cancel" value="Annulla" onclick="return cancelData();">
					</div>	
					<div class="mb-3 px-3 text-center">
						<p>
							Già registrato? <a href="login_form.php">Log in</a>
						</p>
					</div>
				</fieldset>	  
			</form>
		</div>
	</div>
	<script src="../js/email_exists.js"></script>
	<script src="../js/validate_forms.js"></script> 
</body>

<?php  
	ini_set('log_errors', 1);	
	ini_set('error_log', '../../logs/login_form.log');
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<?php 
  	  include "common/common_head.php";
  	?>
	<link href="../style/form_style.css" rel="stylesheet" type="text/css"> 
    <title>Sign-up</title>
</head>

<body id="formbody">
   <div class="row justify-content-center"> 
		<div class="form-container" id="my-form-container">
			<div class="container text-center">
				<img src="../images/logo1.png" alt="Logo" width="150" height="150">
			</div>
			<form id="login_form" name="login_form" action="login.php" autocomplete="off" method="post" onsubmit= "return validateLoginForm();">
				<fieldset>
			
					<div class="mb-3 p-3 mt-3">
						<legend class="text-center">Log in</legend>
						<div class="mb-3 p-3" id="reg_form_div">

							<label for="email" class="mt-1 mb-1">Email</label>
							<input class="form-control input-sm pull-right mb-1" type="email" id="email" name="email" placeholder="email" autocomplete="off">
							<br>
							<span id="email_error" style='color: red;' value=""></span><br>
							
							<label for="pass" class="mt-1 mb-1">Password</label>
							<input class="form-control input-sm pull-right mb-1" type="password" id="pass" name="pass" placeholder="password" autocomplete="off">
							<br>
							<span id="pwd_error" style='color: red;' value=""></span><br>
						</div>
					</div>		
				</fieldset>
				<div class="mb-3 px-3 text-center">	
					<input type="checkbox" id="remember_me" name="remember_me">
					<label for="remember_me">Remember me</label><br>
				</div>		
				<div class="mb-3 px-3 text-center">
						<input class="btn btn-primary" type="submit" id="submit" name="submit" value="Conferma">
						<input class="btn btn-primary" type="button" name="cancel" value="Annulla" onclick="return cancelData();">
				</div>	  
			</form>	
		</div>	
	</div>	
<script src="../js/validate_forms.js"></script>	
</body>
</html>


<?php 
	session_start();
	ini_set('log_errors', 1);	
	ini_set('error_log', '../../logs/show_update_profile.log');
	ob_start();
	require_once ("../php/auth.php");
	denyUnauthenticatedAccess($con);
	require_once("../php/dbconnection.php");
	
	$params = $_SESSION['userid'];
	$query= "SELECT firstname, lastname FROM user WHERE userid=?;";
	$result=fetch_single_result($con, $query,"ss", $params);
	echo $result;
	
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<?php 
		include "common/common_head.php";
	?>
    <title>Update account</title>
</head>

<body>
	<header></header>
	<?php
		include 'common/navbar.php';
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4 text-black">
				<div class="d-flex align-items-center">
					<div class="mb-3 p-3">
					
						<form method="post"  action="update_profile.php" style="width: 23rem;" onsubmit="return validateUpdateProfileForm();"> 
							<fieldset>
								<legend>Aggiorna i tuoi dati</legend>
								<div>
									<label for="firstname" class="my-1">Nome</label>
									<input class="form-control mt-1 mb-2" type="text" id="firstname" name="firstname" value=<?php echo $result["firstname"]?> required>
									<span id="firstname_error" style='color: red;'></span><br>
									<label for="lastname" class="my-1">Cognome</label>
									<input class="form-control mt-1 mb-2" type="text" id="lastname" name="lastname" value=<?php echo $result["lastname"]?> required>
									<span id="lastname_error" style='color: red;'></span><br>
								</div>
								<div class="my-3">
									<input class="btn btn-primary" type="submit" name="submit" value="Ok">
									<input class="btn btn-primary" type="button" name="cancel" value="Annulla" onclick="return cancelData();">
								</div>	
							</fieldset>	 
						</form>
						<a class="py-1" href="update_password_form.php">
							<button class="btn btn-primary">Cambia Password</button>
						</a>
					</div>
				</div>
			</div>	
		</div>
	</div>	
</div>

<?php
	include 'common/footer.php'; 
?>
<script src="../js/validate_forms.js"></script>
	
</body>
</html>	
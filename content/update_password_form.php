<?php
session_start();
ini_set('log_errors', 1);
ini_set('error_log', '../../logs/update_password_form.log');
ob_start();
require("../php/auth.php");
denyUnauthenticatedAccess($con);
?>
<!DOCTYPE html>
<html lang="it">

<head>
	<?php
	include "common/common_head.php";
	?>
	<title>Change password</title>
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
						<form action="update_password.php" method="post" style="width: 23rem;">
							<fieldset>
								<legend>Cambia password:</legend>

								<div class="mb-3 p-3">
									<label>La tua vecchia password</label>
									<input class="form-control mt-1 mb-2" type="password" name="oldpwd" required>
								</div>
								<div class="mb-1 px-3">
									<label>Nuova password</label>
									<input class="form-control mt-1 mb-2" type="password" name="newpwd" required>
									<label>Conferma password</label>
									<input class="form-control mt-1 mb-2" type="password" name="confirm" required>
									<span id="errorpwd"></span>
								</div>
								<div class="mb-1 p-3">
									<input class="btn btn-primary" type="submit" name="submit" value="Ok">
									<input class="btn btn-primary" type="button" name="cancel" value="Annulla" onclick="return cancelData();">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	include 'common/footer.php';
	?>
	<script src="../js/reset_form.js"></script>

</body>
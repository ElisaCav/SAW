<?php
session_start();

ini_set('log_errors', 1);
ini_set('error_log', '../../logs/showprofile.log');

ob_start();
require_once("../php/auth.php");
denyUnauthenticatedAccess($con);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <?php
    include "common/common_head.php";
    ?>
    <title>Account</title>
</head>

<body>
    <?php
    $query = 'SELECT email, firstname, lastname FROM `user` WHERE userid = ?;';
    $row = fetch_single_result($con, $query, 's', $_SESSION['userid']);
    $db_email = $row["email"];
    $db_name = $row["firstname"];
    $db_surname = $row["lastname"];
    ?>
    <?php include 'common/navbar.php'; ?>

    <div class="card mx-5 my-5">
        <h5 class="card-header">Account</h5>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-2 ">
                    <i id="custom-fa" class="fa fa-user fa-5x m-2"></i>
                </div>
                <div class="col-md-10">
                    <h5 class="card-title col-lg-2 sm-8 my-2">
                        <?php
                        echo ($db_name . ' ' . $db_surname);
                        ?>
                    <p class="card-text">email: <?php echo ($db_email); ?></p>
                    <input class="btn btn-primary m-2" type="button" id="updateProfileBtt" value="Aggiorna i tuoi dati"
                        onclick="location='update_profile_form.php'">
                    <input class="btn btn-primary m-2" type="button" id="changePassBtt" value="Cambia password"
                        onclick="location='update_password_form.php'">
                </div>
            </div>
        </div>
    </div>

    <?php include 'common/footer.php'; ?>
</body>

</html>
<?php ob_end_flush(); ?>
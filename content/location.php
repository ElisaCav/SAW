<?php
  session_start();
  ini_set('log_errors', 1);
  ini_set('error_log', '../../logs/location.log');
  ob_start();
  require_once '../php/auth.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <?php 
        include "common/common_head.php";
    ?>
    <title>Location</title>
</head>
<body>
<header></header>
<?php 
    include 'common/navbar.php';
?>
<div class="content-wrapper">
    <div class="location-image-container">
        <img id="location-image" alt="location picture">
    </div>
    <div class="container mt-5 mb-5">
        <table id="location-table" class="table">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="../js/location.js"></script>
<?php include 'common/footer.php'; ?> 

</body>
</html>
<?php ob_end_flush(); ?>

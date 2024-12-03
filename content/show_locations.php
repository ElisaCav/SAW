<?php
session_start();
require_once '../php/auth.php';
ob_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <?php
    include "common/common_head.php";
    ?>
    <title>Locations</title>
</head>

<body>
    <header></header>
    <?php
    include 'common/navbar.php';
    ?>
    <h2 class="mx-4">Le sale</h2>
    <div id="locations" class="row mx-3 mb-3 row-cols-1 row-cols-md-3 g-4">
    </div>

    <?php
    include 'common/footer.php';
    ?>

    <script src="../js/show_locations.js"></script>

</body>
<?php
session_start();
ini_set('log_errors', 0);
ini_set('error_log', '../../logs/cart.log');
ob_start();
require_once '../db/mysql_credentials.php';
require_once '../php/auth.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <?php
    include "common/common_head.php";
    ?>
    <title>Cart</title>
</head>

<body>
    <header></header>
    <?php
    include 'common/navbar.php';
    ?>

    <div class="container mt-5">
        <h2 class="text-center">Il tuo carrello</h2>
        <div id="cartItems" class="container mt-5">
            <!-- Template for cart item -->
            <div id="cardTemplate" class="card mt-3" style="display: none">
                <div
                    class="card-body card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
                    <p class="card-text">
                        <strong>Location:</strong> <span class="cart-item-location"></span><br>
                        <strong>Data:</strong> <span class="cart-item-date"></span><br>
                        <strong>Ora:</strong> <span class="cart-item-time"></span><br>
                        <strong>Durata:</strong> <span class="cart-item-duration"></span> ore.<br>
                        <strong>Subtotale:</strong> <span class="cart-item-total-price"></span> euro.<br>
                    </p>
                    <div class="d-lg-flex justify-content-lg-end">
                        <button id="buyBtn" class="btn btn-primary mt-3 mt-lg-0 me-lg-2">Compra</button>
                        <button id="removeBtn" class="btn btn-danger mt-3 mt-lg-0">Rimuovi</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5 mb-5" id="show-total" name="show-total" style="display: none;">
            <h5 id="total" name="total">Totale carrello: <span id="total-price" name="total-price"></span> €</h5>
        </div>


        <div id="cart-btn" name="cart-btn" style="display: flex; justify-content: center; align-items: center;">
            <?php if (isset($_SESSION['userid'])) {
            ?>
                <button class="btn btn-primary m-3" id="buyAllBtn" style="display: none;">Compra tutto</button>
            <?php
            }
            ?>
            <button class="btn btn-primary m-3" id="emptyCartBtn" style="display: none;">Svuota il carrello</button>
        </div>

    </div>

    <?php
    include 'common/footer.php';
    ?>

    <script src="../js/cart_functions.js"></script>

</body>

</html>
<?php ob_end_flush(); ?>
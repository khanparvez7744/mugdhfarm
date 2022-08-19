<?php require_once('header.php'); ?>

<?php

unset($_SESSION['cart_p_id']);
unset($_SESSION['cart_p_mode']);
unset($_SESSION['cart_p_product_qty']);

header('location: cart.php');
?>
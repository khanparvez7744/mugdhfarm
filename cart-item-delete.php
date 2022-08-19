<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['id']) ) {
    header('location: cart.php');
    exit;
}

$i=0;
foreach($_SESSION['cart_p_id'] as $key => $value) {
    $i++;
    $arr_cart_p_id[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_p_mode'] as $key => $value) {
    $i++;
    $arr_cart_mode[$i] = $value;
}

// $i=0;
// foreach($_SESSION['cart_p_product_qty'] as $key => $value) {
//     $i++;
//     $arr_cart_p_product_qty[$i] = $value;
// }

unset($_SESSION['cart_p_id']);
unset($_SESSION['cart_p_mode']);
//unset($_SESSION['cart_p_product_qty']);

$k=1;
for($i=1;$i<=count($arr_cart_p_id);$i++) {
    if( ($arr_cart_p_id[$i] == $_REQUEST['id']) ) {
        continue;
    } else {
        $_SESSION['cart_p_id'][$k] = $arr_cart_p_id[$i];
        $_SESSION['cart_p_mode'][$k] = $arr_cart_size_id[$i];
        //$_SESSION['cart_p_product_qty'][$k] = $arr_cart_size_name[$i];
        $k++;
    }
}
header('location: cart.php');
?>
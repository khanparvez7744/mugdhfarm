<?php require_once('header.php'); ?>

<?php

if( !isset($_REQUEST['id']) ) {
    header('location: cart.php');
    exit;
}
                          $i=0;
                          foreach($_SESSION['subs_cart_p_id'] as $value) 
                          {
                              $i++;
                              $subs_cart_p_id[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cart_p_mode'] as $value) 
                          {
                              $i++;
                              $subs_cart_p_mode[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cartschedule_type'] as $value) 
                          {
                              $i++;
                              $subs_cartschedule_type[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cart_p_product_qty'] as $value) 
                          {
                              $i++;
                              $subs_cart_p_product_qty[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cartdelivery_start_date'] as $value) 
                          {
                              $i++;
                              $subs_cartdelivery_start_date[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cartaltdays'] as $value) 
                          {
                              $i++;
                              $subs_cartaltdays[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseMquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseMquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseTquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseTquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseWquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseWquant[$i] = $value;
                          }                          
                          $i=0;
                          foreach($_SESSION['subs_customiseTHquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseTHquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseFquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseFquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseSATquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseSATquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_customiseSUNquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseSUNquant[$i] = $value;
                          }

unset($_SESSION['subs_cart_p_id']);
unset($_SESSION['subs_cart_p_mode']);
unset($_SESSION['subs_cartschedule_type']);
unset($_SESSION['subs_cart_p_product_qty']);
unset($_SESSION['subs_cartdelivery_start_date']);
unset($_SESSION['subs_cartaltdays']);
unset($_SESSION['subs_customiseMquant']);
unset($_SESSION['subs_customiseTquant']);
unset($_SESSION['subs_customiseWquant']);
unset($_SESSION['subs_customiseTHquant']);
unset($_SESSION['subs_customiseFquant']);
unset($_SESSION['subs_customiseSATquant']);
unset($_SESSION['subs_customiseSUNquant']);

$k=1;
for($i=1;$i<=count($subs_cart_p_id);$i++) {
    if( ($subs_cart_p_id[$i] == $_REQUEST['id']) ) {
        continue;
    } else {
        $_SESSION['subs_cart_p_id'][$k] = $subs_cart_p_id[$i];
        $_SESSION['subs_cart_p_mode'][$k] = $subs_cart_p_mode[$i];
        $_SESSION['subs_cartschedule_type'][$k] = $subs_cartschedule_type[$i];
        $_SESSION['subs_cart_p_product_qty'][$k] = $subs_cart_p_product_qty[$i];
        $_SESSION['subs_cartdelivery_start_date'][$k] = $subs_cartdelivery_start_date[$i];
        $_SESSION['subs_cartaltdays'][$k] = $subs_cartaltdays[$i];
        $_SESSION['subs_customiseMquant'][$k] = $subs_customiseMquant[$i];
        $_SESSION['subs_customiseTquant'][$k] = $subs_customiseTquant[$i];
        $_SESSION['subs_customiseWquant'][$k] = $subs_customiseWquant[$i];
        $_SESSION['subs_customiseTHquant'][$k] = $subs_customiseTHquant[$i];
        $_SESSION['subs_customiseFquant'][$k] = $subs_customiseFquant[$i];
        $_SESSION['subs_customiseSATquant'][$k] = $subs_customiseSATquant[$i];
        $_SESSION['subs_customiseSUNquant'][$k] = $subs_customiseSUNquant[$i];
        $k++;
    }
}
header('location: cart.php');
?>
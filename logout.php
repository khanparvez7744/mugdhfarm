<?php 
ob_start();
session_start();
include 'admin/inc/config.php';
unset($_SESSION['loggedin_userid']);
unset($_SESSION['loggedin_user_phone']);
header("location: ".BASE_URL); 
?>
<?php

error_reporting(1); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("BASE_URL", "https://mugdhfarm.com/mugdha2/");

$conn = mysqli_connect("localhost", "mugdhadb", "mugdhadb", "mugdhadb");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
?>
<?php
//session variables
session_start();
$fpava_setses=isset($_SESSION['fullname']) and isset($_SESSION['userid']) and isset($_SESSION['email']);
$fpava_ntsetses=!isset($_SESSION['fullname']) and !isset($_SESSION['userid']) and !isset($_SESSION['email']);
$fpava_ntsetcoo=!isset($_COOKIE['fullname']) and !isset($_COOKIE['userid']) and !isset($_COOKIE['email']);

//database variables
$fpava_dbip="localhost";
$fpava_user="root";
$fpava_pass="ambujsharma";
$fpava_dbname="almaconnect";

//image upload path
define('fpava_imgpath','images/');

//setting timezone
date_default_timezone_set('UTC');
?>

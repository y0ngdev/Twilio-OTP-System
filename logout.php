<?php 
ob_start();
session_start();
//includes app  config file
require_once('config.php');
//Unset the session variable 
unset($_SESSION['user']);
//destroy created session
session_destroy();
// Redirect to login page
header("location: signin.php");


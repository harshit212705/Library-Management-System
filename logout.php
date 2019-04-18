<?php
error_reporting(0);
session_start();

if (!$_SESSION['username'])
	header('location:signin.php');

session_unset();
header('location:signin.php');
?>

<?php

ob_start(); 

session_start();

$timezone = date_default_timezone_set("Asia/Jakarta"); 

$con = mysqli_connect("localhost", "root", "", "buddy"); 


if(mysqli_connect_errno()) {

	echo "Failed to connect: " . mysqli_connect_errno();
}


?>
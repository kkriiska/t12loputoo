<?php 
	// functions.php
	require("/home/karokrii/config.php");
	
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start(); 
	
	/* ÜHENDUS */
	$database = "if16_karokrii";
	$mysqli = new mysqli($serverHost, $serverUsername,  $serverPassword, $database);
	
?>
<?php //open php tag, no need to close it if the entire file is php

$serverName = "localhost"; //name of the server you're connecting to
$dbUsername = "root"; //username that you set
$dbPassword = ""; //password that you set, empty if not set
$dbName = "splicetesting"; //name of the database you created in the server

//this php function connects to the DB with the prev variables
$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn){
	die("Connection failed: ".mysqli_connect_error());
}

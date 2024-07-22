<?php

$dbhost = "localhost";
$dbuser = "VoidUsers";
$dbpass = "";
$dbname = "flavor_town";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
?>
<?php

session_start();

if(isset($_SESSION['email']))
{
	unset($_SESSION['email']);

}
header("Location: http://localhost/flavor_town/flavor_town_front/index.html");
die;
?>
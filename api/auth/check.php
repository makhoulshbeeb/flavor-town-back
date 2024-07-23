<?php

session_start();

include("../connection.php");

if (isset($_SESSION['email'])){
    echo true;
}else{
    echo false;
}
<?php
session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $params = json_decode($data, true);
    
    $username = $params['username'];
    $password = $params['password'];
    $password=password_hash($password,PASSWORD_BCRYPT_DEFAULT_COST);
    $email = $params['email'];

    if (!is_numeric($username)) {
        $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?,?,?)");
        $stmt->bind_param(
            'sss',
            $username,
            $password,
            $email
        );
        $stmt->execute();
        die;
    } else {
        return false;
    }
}

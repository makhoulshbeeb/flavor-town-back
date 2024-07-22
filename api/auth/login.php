<?php

session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $params = json_decode($data, true);
    $email = $params['email'];
    $password = $params['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $userData = mysqli_fetch_assoc($result);
        if (password_verify($userData['password'],$password)) {

            $_SESSION['email'] = $userData['email'];
            echo true;
        }
    }

    echo false;
}
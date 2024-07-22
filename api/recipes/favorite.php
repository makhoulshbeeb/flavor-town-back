<?php
session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $params = json_decode($data, true);

    $recipe_id = $params['recipe_id'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $userData = mysqli_fetch_assoc($result);
        $user_id = $userData['user_id'];
        
        $stmt2 = $conn->prepare("INSERT INTO favorites (recipe_id, user_id) VALUES (?,?)");
        $stmt2->bind_param('ii', $recipe_id, $user_id);

        $stmt3 = $conn->prepare("DELETE FROM favorites WHERE recipe_id = ? AND user_id = ?");
        $stmt3->bind_param('ii', $recipe_id, $user_id);

        $stmt2->execute() or $stmt3->execute(); 
        echo true;

    } else {
        echo false;
    }
    die;
}

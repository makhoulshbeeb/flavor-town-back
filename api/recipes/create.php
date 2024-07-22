<?php
session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_SESSION['email'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $userData = mysqli_fetch_assoc($result);
        $user_id = $userData['user_id'];
        $data = file_get_contents("php://input");
        $params = json_decode($data, true);

        $recipe_name = $params['recipe_name'];
        $description = $params['description'];
        $image = $params['image'];
        $preparation_time = $params['preparation_time'];
        $cooking_time = $params['cooking_time'];

        $stmt2 = $conn->prepare("INSERT INTO recipes (user_id, name, description, image_url, preparation_time, cooking_time) VALUES (?,?,?,?,?,?)");
        $stmt2->bind_param('isssss', $user_id, $recipe_name, $description, $image, $preparation_time, $cooking_time);
        $stmt2->execute();

        $recipe_id=mysqli_insert_id($conn);
        $ingredient_list = json_decode($params['$ingredient_list'],true);
        $step_list = json_decode($params['step_list'],true);

        foreach($ingredient_list as $ingredient => $quantity){
            $stmt3 = $conn->prepare("INSERT INTO ingredients (recipe_id, name, quantity) VALUES (?,?,?)");
            $stmt3->bind_param('iss',$recipe_id,$ingredient,$quantity);
            $stmt3->execute();
        }
        foreach($step_list as $step_number => $instruction){
            $stmt4 = $conn->prepare("INSERT INTO recipesteps (recipe_id, step_number, instruction) VALUES (?,?,?)");
            $stmt4->bind_param('iis',$recipe_id,$step_number,$instruction);
            $stmt4->execute();
        }
        
        echo true;
    } else {
        echo false;
    }
    die;
}

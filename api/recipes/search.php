<?php
session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $params = json_decode($data, true);

    $recipe_name = $params['recipe_name'];
    $recipe_name = '%'.$recipe_name.'%';

    $stmt = $conn->prepare('SELECT * FROM recipes WHERE name LIKE ? ORDER BY id DESC');
    $stmt->bind_param('s', $recipe_name);
    $stmt->execute();

    $result = $stmt->get_result();
    $recipes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
        echo json_encode($recipes);
    }
    die;
}

<?php
session_start();

include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $params = json_decode($data, true);

    $recipe_id = $params['recipe_id'];

    $stmt = $conn->prepare('SELECT * FROM recipesteps WHERE recipe_id = ? ORDER BY step_number');
    $stmt->bind_param('i', $recipe_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $recipesteps = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipesteps[] = $row;
        }
        echo json_encode($recipesteps);
    }
    die;
}
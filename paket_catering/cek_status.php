<?php

header('Content-Type: application/json');

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_catering"
);

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT status FROM pesanan WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

echo json_encode([
    "status" => $data['status']
]);
?>
<?php

header('Content-Type: application/json');

$conn = mysqli_connect(
    "mif.myhost.id",
    "mifmyho2_B4",
    "@MIF2025",
    "mifmyho2_B4"
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
<?php
require_once('../includes/load.php');


$sql = "SELECT * FROM products WHERE quantity < low_stock";
$result = $db->query($sql);

$response = [];
if ($db->num_rows($result) > 0) {
    while ($row = $db->fetch_assoc($result)) {
        $response[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

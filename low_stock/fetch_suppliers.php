<?php
require_once('../includes/load.php');


$sql = "SELECT * from suppliers where status = 1";

$result = $db->query($sql);


// Fetch items as an array
$suppliers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($suppliers);

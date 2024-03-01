<?php
require_once('../includes/load.php');





// Fetch items as an array
$items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($items);

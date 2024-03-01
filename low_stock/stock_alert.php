<?php
// Get updated cart count
require_once('../includes/load.php');
$CountQuery = "SELECT COUNT(*) AS alertCount FROM products WHERE quantity <= low_stock";
$CountResult = $db->query($CountQuery);
$alertCount = $CountResult ? $CountResult->fetch_assoc()['alertCount'] : 0;

echo json_encode([
    'alertCount' => $alertCount
]);
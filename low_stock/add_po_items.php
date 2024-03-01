<?php
require_once('../includes/load.php');
page_require_level(2);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_REQUEST;
    $product_id = $data['id'];
    $quantity = $data['quantity'];
    $user_id = $_SESSION['user_id'];
    $checkCartQuery = "SELECT * 
    FROM po_items 
    WHERE user_id = $user_id 
    AND item_id = $product_id 
    AND item_status IS NULL";
    $result = $db->query($checkCartQuery);
    if ($result && $result->num_rows > 0) {
        $updateQuery = "UPDATE po_items SET quantity = quantity + $quantity WHERE user_id = $user_id AND item_id = $product_id AND item_status = 0";
        $db->query($updateQuery);
    } else {
        $insertQuery = "INSERT INTO po_items (user_id, item_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        $db->query($insertQuery);
    }
    $cartCountQuery = "SELECT COUNT(list_id) AS itemCount FROM po_items WHERE user_id = $user_id AND item_status = 0 ";
    $cartCountResult = $db->query($cartCountQuery);
    $itemCount = $cartCountResult ? $cartCountResult->fetch_assoc()['itemCount'] : 0;
    echo json_encode([
        'itemCount' => $itemCount
    ]);
    exit();
} else {
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid JSON data'));
}

<?php
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['items']) && isset($_POST['supplier'])) {

        $items = $_POST['items'];
        $supplier = $_POST['supplier'];


        foreach ($items as $item) {

            $itemId = $item['id'];
            $quantity = $item['qty'];
            $sql = "INSERT INTO purchase_order (item_id, quantity, supplier_id) VALUES ($itemId, $quantity, $supplier)";

        }


        $response = array("status" => "success", "message" => "Items inserted successfully.");
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Incomplete data provided.");
        echo json_encode($response);
    }
} else {

    $response = array("status" => "error", "message" => "Invalid request method.");
    echo json_encode($response);
}

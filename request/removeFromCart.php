<?php

require_once('../includes/load.php');
page_require_level(2);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = $_POST;
    $product_id = $data['id'];
    $table = $data['table'];
    $sql = "DELETE FROM $table WHERE item_id = $product_id";
    $result = $db->query($sql);

    echo json_encode([
        'result' => $result
    ]);
    exit();
}
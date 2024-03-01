<?php
require_once('../includes/load.php');

page_require_level(2);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = $_REQUEST;

    $product_id = $data['id'];
    $quantity = $data['quantity'];

    $user_id = $_SESSION['user_id'];
    $checkCartQuery = "SELECT * FROM cart WHERE user_id = $user_id AND prod_id = $product_id";
    $result = $db->query($checkCartQuery);

    if ($result && $result->num_rows > 0) {

        $updateQuery = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND prod_id = $product_id";
        $db->query($updateQuery);
    } else {

        $insertQuery = "INSERT INTO cart (user_id, prod_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        $db->query($insertQuery);
    }


    $cartCountQuery = "SELECT COUNT(*) AS cartCount FROM cart WHERE user_id = $user_id";
    $cartCountResult = $db->query($cartCountQuery);
    $cartCount = $cartCountResult ? $cartCountResult->fetch_assoc()['cartCount'] : 0;

    echo json_encode([
        'cartCount' => $cartCount
    ]);


    exit();
} else {
    echo $_SERVER["REQUEST_METHOD"];
    die();
}

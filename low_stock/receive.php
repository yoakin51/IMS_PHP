<?php

require_once('../includes/load.php');
page_require_level(3);

if (isset($_GET['po_id'])) {
    $po_id = $_GET['po_id'];
    $sql = "SELECT p.*,o.list_id,o.quantity as po_quantity,o.user_id,o.po_id from po_items o join products p on p.prod_id = o.item_id where o.po_id= $po_id";
    $results = find_by_sql($sql);

    foreach ($results as $res):
        $update = "UPDATE products SET quantity = quantity + $res[po_quantity]";
        $db->query($update);



    endforeach;

    $status = "UPDATE purchase_order SET status = 1 where po_id = $po_id";
    $result = $db->query($status);
    if ($result) {
        $session->msg("s", "stock recieved.");
        redirect('order_list.php');
    } else {
        $session->msg("d", "failed.");
        redirect('order_list.php');
    }
}
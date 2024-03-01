<?php

require_once('../includes/load.php');
page_require_level(3);

if (isset($_GET['list_id'])) {


    $list_id = $_GET['list_id'];
    $sql = "DELETE FROM po_items WHERE list_id = $list_id and item_status = 0";
    $result = $db->query($sql);
    if ($result) {
        $session->msg("s", "Item has been deleted.");
        redirect('make_purchase.php');
    } else {
        $session->msg("d", "deletion failed.");
        redirect('make_purchase.php');
    }

}
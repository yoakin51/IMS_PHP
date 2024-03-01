<?php

require_once('../includes/load.php');
page_require_level(3);

if (isset($_GET['po_id'])) {


    $list_id = $_GET['po_id'];
    $sql = "DELETE from po_items where po_id = $list_id";



    $db->query($sql);
    $again = "DELETE from purchase_order where po_id = $list_id";
    $db->query($again);
    if ($again) {
        $session->msg("s", "Item has been deleted.");
        redirect('order_list.php');
    } else {
        $session->msg("d", "deletion failed.");
        redirect('order_list.php');
    }

}
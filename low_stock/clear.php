<?php

require_once('../includes/load.php');
page_require_level(3);




$sql = "DELETE FROM po_items WHERE item_status = 0";
$result = $db->query($sql);
if ($result) {
    $session->msg("s", "cleared.");
    redirect('low_stocks.php');
} else {
    $session->msg("d", "deletion failed.");
    redirect('low_stocks.php');
}


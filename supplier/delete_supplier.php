<?php
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
$delete_id = delete_by_id('supplier', (int) $_GET['SUPPLIER_ID']);
if ($delete_id) {
  $session->msg("s", "Supplier has been deleted.");
  redirect('supplier.php');
} else {
  $session->msg("d", "Supplier deletion failed Or Missing Prm.");
  redirect('supplier.php');
}
?>
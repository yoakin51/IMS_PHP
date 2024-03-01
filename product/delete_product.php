<?php
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
$product = find_by_id('products', (int) $_GET['prod_id']);
if (!$product) {
  $session->msg("d", "Missing Product id.");
  redirect('product.php');
}
?>
<?php
$delete_id = delete_by_id('products', (int) $product['prod_id']);
if ($delete_id) {
  $session->msg("s", "Products deleted.");
  redirect('product.php');
} else {
  $session->msg("d", "Products deletion failed.");
  redirect('product.php');
}
?>
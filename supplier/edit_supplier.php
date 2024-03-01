<?php
$page_title = 'Edit Supplier';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
$e_group = find_supplier_by_id((int) $_GET['SUPPLIER_ID']);
if (!$e_group) {
  $session->msg("d", "Missing supplier id.");
  redirect('supplier.php');
}
?>
<?php
if (isset($_POST['update'])) {

  $req_fields = array('name', 'email', 'status', 'phone');
  validate_fields($req_fields);
  if (empty($errors)) {
    $name = remove_junk($db->escape($_POST['name']));
    $mail = remove_junk($db->escape($_POST['email']));
    $phone = remove_junk($db->escape($_POST['phone']));
    $status = remove_junk($db->escape($_POST['status']));

    $query = "UPDATE supplier SET ";
    $query .= "COMPANY_NAME='{$name}',email='{$mail}',PHONE_NUMBER='{$phone}',status='{$status}'";
    $query .= "WHERE SUPPLIER_ID='{$db->escape($e_group['SUPPLIER_ID'])}'";
    $result = $db->query($query);
    if ($result && $db->affected_rows() === 1) {
      //sucess
      $session->msg('s', "Supplier has been updated! ");
      redirect('edit_supplier.php?SUPPLIER_ID=' . (int) $e_group['SUPPLIER_ID'], false);
    } else {
      //failed
      $session->msg('d', ' Sorry failed to update SUPPLIER!');
      redirect('edit_supplier.php?SUPPLIER_ID=' . (int) $e_group['SUPPLIER_ID'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_supplier.php?SUPPLIER_ID=' . (int) $e_group['SUPPLIER_ID'], false);
  }
}
?>
<?php include_once('../layouts/header.php'); ?>
<div class="login-page">
  <div class="text-center">
    <h3>Edit Supplier</h3>
  </div>
  <?php echo display_msg($msg); ?>
  <form method="post" action="edit_supplier.php?SUPPLIER_ID=<?php echo (int) $e_group['SUPPLIER_ID']; ?>"
    class="clearfix">
    <div class="form-group">
      <label for="name" class="control-label">Company Name</label>
      <input type="name" class="form-control" name="name"
        value="<?php echo remove_junk(ucwords($e_group['COMPANY_NAME'])); ?>">
    </div>
    <div class="form-group">
      <label for="level" class="control-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?php echo $e_group['email']; ?>">
    </div>
    <div class="form-group">
      <label for="level" class="control-label">Phone</label>
      <input type="number" class="form-control" name="phone" value="<?php echo (int) $e_group['PHONE_NUMBER']; ?>">
    </div>
    <div class="form-group">
      <label for="status">Status</label>
      <select class="form-control" name="status">
        <option <?php if ($e_group['status'] === '1')
          echo 'selected="selected"'; ?> value="1"> Active </option>
        <option <?php if ($e_group['status'] === '0')
          echo 'selected="selected"'; ?> value="0">Deactive</option>
      </select>
    </div>
    <div class="form-group clearfix">
      <button type="submit" name="update" class="btn btn-info">Update</button>
    </div>
  </form>
</div>

<?php include_once('../layouts/footer.php'); ?>
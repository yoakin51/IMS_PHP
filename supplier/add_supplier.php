<?php
$page_title = 'Add Supplier';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
if (isset($_POST['add'])) {

  $req_fields = array('name', 'email', 'phone', 'status');
  validate_fields($req_fields);

  if (find_by_groupName($_POST['COMPANY_NAME']) === false) {
    $session->msg('d', '<b>Sorry!</b> Entered Name already in database!');
    redirect('add_supplier.php', false);
  } elseif (find_by_groupLevel($_POST['email']) === false) {
    $session->msg('d', '<b>Sorry!</b> Entered email already in database!');
    redirect('add_supplier.php', false);
  }
  if (empty($errors)) {
    $name = remove_junk($db->escape($_POST['name']));
    $mail = remove_junk($db->escape($_POST['email']));
    $phone = remove_junk($db->escape($_POST['phone']));
    $status = remove_junk($db->escape($_POST['status']));
    $query = "INSERT INTO supplier (";
    $query .= "COMPANY_NAME,email,PHONE_NUMBER,status";
    $query .= ") VALUES (";
    $query .= " '{$name}', '{$mail}','{$phone}','{$status}'";
    $query .= ")";
    if ($db->query($query)) {
      //sucess
      $session->msg('s', "Supplier has been creted! ");
      redirect('add_supplier.php', false);
    } else {
      //failed
      $session->msg('d', ' Sorry failed to create supplier!');
      redirect('add_supplier.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_supplier.php', false);
  }
}
?>
<?php include_once('../layouts/header.php'); ?>
<div class="login-page">
  <div class="text-center">
    <h3>Add new supplier</h3>
  </div>
  <?php echo display_msg($msg); ?>
  <form method="post" action="add_supplier.php" class="clearfix">
    <div class="form-group">
      <label for="name" class="control-label">Name</label>
      <input type="name" class="form-control" name="name" required>
    </div>
    <div class="form-group">
      <label for="email" class="control-label">Email</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    <div class="form-group">
      <label for="phone" class="control-label">Phone</label>
      <input type="numbers" class="form-control" name="phone" required>
    </div>
    <div class="form-group">
      <label for="status">Status</label>
      <select class="form-control" name="status" required>
        <option value="1">Active</option>
        <option value="0">Deactive</option>
      </select>
    </div>
    <div class="form-group clearfix">
      <button type="submit" name="add" class="btn btn-info">Save</button>
    </div>
  </form>
</div>

<?php include_once('../layouts/footer.php'); ?>
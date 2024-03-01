<?php
$page_title = 'All Suppliers';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
$all = find_all('supplier');
?>
<?php include_once('../layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Suppliers</span>
        </strong>
        <a href="add_supplier.php" class="btn btn-info pull-right btn-sm"> Add New Supplier</a>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Company Name</th>
              <th class="text-center" style="width: 20%;">Email</th>
              <th class="text-center" style="width: 15%;">Phone</th>
              <th class="text-center" style="width: 15%;">Status</th>
              <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all as $supplier): ?>
              <tr>
                <td class="text-center">
                  <?php echo count_id(); ?>
                </td>
                <td>
                  <?php echo remove_junk(ucwords($supplier['COMPANY_NAME'])) ?>
                </td>
                <td class="text-center">
                  <?php echo remove_junk(ucwords($supplier['email'])) ?>
                </td>
                <td class="text-center">
                  <?php echo remove_junk($supplier['PHONE_NUMBER']) ?>
                </td>
                <td class="text-center">
                  <?php if ($supplier['status'] === '1'): ?>
                    <span class="label label-success">
                      <?php echo "Active"; ?>
                    </span>
                  <?php else: ?>
                    <span class="label label-danger">
                      <?php echo "Deactive"; ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_supplier.php?SUPPLIER_ID=<?php echo (int) $supplier['SUPPLIER_ID']; ?>"
                      class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                      <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                    <a href="delete_supplier.php?SUPPLIER_ID=<?php echo (int) $supplier['SUPPLIER_ID']; ?>"
                      class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                      <i class="glyphicon glyphicon-remove"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('../layouts/footer.php'); ?>
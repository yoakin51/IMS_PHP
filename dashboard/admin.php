<?php
$page_title = 'Admin dashboard';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
$c_categorie = count_by_id('categories');
$c_user = count_by_id('users');
$c_product = count_products('products');
$c_departments = count_by_different('departments', 'dep_id');
$products_requested = find_highest_requested_product('10');
$recent_products = find_recent_product_added('8');
$recent_requests = find_recent_request_added('6');
$recent_issues = find_recent_issued('6');
$all_users = find_all_user();
?>
<?php include_once('../layouts/header.php'); ?>

<!--<div class="main-content">-->
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <a href="../user/users.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top">
            <?php echo $c_user['total']; ?>
          </h2>
          <p class="text-muted">Users</p>
        </div>
      </div>
    </div>
  </a>
  <a href="../department/departments.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-usd"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top">
            <?php echo $c_departments['total']; ?>
          </h2>
          <p class="text-muted">Departments</p>
        </div>
      </div>
    </div>
  </a>
  <a href="../category/category.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top">
            <?php echo $c_categorie['total']; ?>
          </h2>
          <p class="text-muted">Categories</p>
        </div>
      </div>
    </div>
  </a>

  <a href="../request/product_list.php" style="color:black;">
    <div class="col-md-3">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top">
            <?php echo $c_product['total']; ?>
          </h2>
          <p class="text-muted">Products</p>
        </div>
      </div>
    </div>
  </a>


</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Highly Requested Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table  table-bordered table-condensed">
          <thead>
            <tr>
              <th>Title</th>
              <th>Total Sold</th>
              <th>Total Quantity</th>
            <tr>
          </thead>
          <tbody>
            <?php foreach ($products_requested as $product_reqs): ?>
              <tr>
                <td>
                  <?php echo remove_junk(first_character($product_reqs['prod_name'])); ?>
                </td>
                <td>
                  <?php echo (int) $product_reqs['totalSold']; ?>
                </td>
                <td>
                  <?php echo (int) $product_reqs['totalQty']; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>LATEST Requisitions</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product Name</th>
              <th>Date</th>
              <th>Total Sale</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_requests as $recent_req): ?>
              <tr>
                <td class="text-center">
                  <?php echo count_id(); ?>
                </td>
                <td>
                  <a href="../sale/edit_sale.php?id=<?php echo (int) $recent_req['request_id']; ?>">
                    <?php echo remove_junk(first_character($recent_req['prod_name'])); ?>
                  </a>
                </td>
                <td>
                  <?php echo remove_junk(ucfirst($recent_req['timestamp'])); ?>
                </td>
                <td>ETB
                  <?php echo remove_junk(first_character($recent_req['buy_price'])); ?>
                </td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class=" col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
          <?php foreach ($recent_products as $recent_product): ?>
            <a class="list-group-item clearfix"
              href="../request/product_list.php?prod_id=<?php echo (int) $recent_product['prod_id']; ?>">
              <h4 class=" list-group-item-heading">

                <?php echo remove_junk(first_character($recent_product['prod_name'])); ?>
                <span class="label label-warning pull-right">
                  ETB
                  <?php echo (int) $recent_product['buy_price']; ?>
                </span>
              </h4>
              <span class="list-group-item-text pull-right">
                <?php echo remove_junk(first_character($recent_product['category'])); ?>
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class=" col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Issued Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product Code</th>
              <th>Title</th>
              <th>Date</th>
              <th>Quantity</th>
              <th>Cost</th>
              <th>Issued_by</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_issues as $recent_issue): ?>
              <tr>
                <td class="text-center">
                  <?php echo count_id(); ?>
                </td>
                <td>
                  <a href="#">
                    <?php echo remove_junk(first_character($recent_issue['prod_name'])); ?>
                    < </td>
                <td>
                  <?php echo remove_junk(ucfirst($recent_issue['timestamp'])); ?>
                </td>
                <td>ETB
                  <?php echo remove_junk(first_character($recent_issue['buy_price'])); ?>
                </td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class=" col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Login</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table  table-bordered table-condensed">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>User name</th>
              <th>Phone number</th>
              <th>Last Login</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_users as $user): ?>
              <tr>
                <td class="text-center">
                  <?php echo count_id(); ?>
                </td>
                <td>
                  <a href="#">
                    <?php echo remove_junk(first_character($user['name'])); ?>
                </td>
                <td>
                  <?php echo remove_junk(ucfirst($user['department'])); ?>
                </td>
                <td>
                  <?php echo remove_junk(first_character($user['last_login'])); ?>
                </td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--< /div>-->
<!-- <script>
  $(document).ready(function () {
    // Click event for sidebar links
    $('.sidebar-link').click(function (event) {
      event.preventDefault(); // Prevent default link behavior

      var url = $(this).data('url'); // Get the URL from data attribute
      var mainContent = $('.main-content'); // Find the main content area

      // Load content using AJAX
      $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
          // Replace main content with the loaded content
          mainContent.html(response);
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error(xhr.responseText);
        }
      });
    });
  });
</script> -->

<?php include_once('../layouts/footer.php'); ?>
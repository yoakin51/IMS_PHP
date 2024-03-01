<ul>
  <li>
    <a href=" ../dashboard/admin.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Departments</span>

    </a>
    <ul class="nav submenu">
      <li><a href="../department/departments.php">Manage Departments</a> </li>
      <li><a href="../department/add_department.php">Add Departments</a> </li>
    </ul>
  </li>
  <li>

    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-user"></i>
      <span>User Management</span>

    </a>
    <ul class="nav submenu">
      <li><a href="../group/group.php">Manage Groups</a> </li>
      <li><a href="../user/users.php">Manage Users</a> </li>
    </ul>
  </li>
  <li>
    <a href="../category/category.php">
      <i class="glyphicon glyphicon-indent-left"></i>
      <span>Categories</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Products</span>
    </a>
    <!-- <ul class="nav submenu">
      <li><a href="../product/product.php">Manage Products</a> </li>
      <li><a href="../product/add_product.php">Add Products</a> </li>
    </ul> -->
  </li>
  <!-- <li>
    <a href="../media/media.php">
      <i class="glyphicon glyphicon-picture"></i>
      <span>Media Files</span>
    </a>
    </li>-->
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-credit-card"></i>
      <span>Requests</span>

    </a>
    <ul class="nav submenu">
      <!--<li><a href="../request/request.php">Store requisition</a>
  </li>-->
      <li><a href="../request/requester_history.php">History</a></li>
      <li><a href="../request/product_list.php">Products List</a></li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-credit-card"></i>
      <span>Supplier</span>
    </a>
    <ul class="nav submenu">
      <li><a href="../supplier/supplier.php">Manage Suppliers</a> </li>
      <li><a href="../supplier/add_supplier.php">Add Supplier</a> </li>
    </ul>
  </li> <!--
  <li>
    <a href="../sale/sales_report.php" class="submenu-toggle">

      <i class="glyphicon glyphicon-duplicate"> </i>
      <span>Report<span>
    </a>
    <ul class="nav submenu">
  <li></li>
  <li><a href="../sale/monthly_sales.php">Monthly </a></li>
  <li><a href="../sale/daily_sales.php">Daily </a></li>
</ul>-->
  </li>
</ul>
<script>
  $(document).ready(function () {
    function low_stock_alert() {
      $.ajax({
        type: "GET",
        url: "../low_stock/stock_alert.php",
        success: function (response) {
          console.log(response);
          var requestAlert = JSON.parse(response).alertCount;
          $("#request_alert").text(requestAlert);
        }
      });
    }
    setInterval(low_stock_alert, 20000);


    // $("#sidebar a").click(function (event) {
    //   event.preventDefault();
    //   var href = $(this).attr("href");

    //   $.ajax({
    //     url: href,
    //     type: "GET",
    //     dataType: "html",
    //     success: function (response) {
    //       $("#main-content").html(response);
    //     },
    //     error: function (xhr, status, error) {
    //       console.error(xhr.responseText);
    //     }
    //   });
  });
  });</script>
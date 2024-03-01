<?php require_once("../includes/load.php"); ?>
<ul>
  <li>
    <a href="../dashboard/home.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Requisitions</span>
    </a>
    <ul class="nav submenu">
      <li><a href="../request/requisitions.php">New Requisitions</a> </li>
      <li><a href="../request/requisitions_history.php">History</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-list"></i>
      <span>Purchase order</span>
      <sup class="d-inline-block text-danger" id="request_alert">0</sup>
    </a>
    <ul class="nav submenu">
      <li><a href="../low_stock/low_stocks.php">Low-Stock</a></li>
      <li><a href="../low_stock/order_list.php">Order List</a></li>
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
      <i class="glyphicon glyphicon-credit-card"></i>
      <span>Supplier</span>
    </a>
    <ul class="nav submenu">
      <li><a href="../supplier/supplier.php">Manage Suppliers</a> </li>
      <li><a href="../supplier/add_supplier.php">Add Supplier</a> </li>
    </ul>
  </li>
  <li>
    <a href="../sale/sales_report.php" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
      <span>Report</span>
    </a>
  </li>

  <!--
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Products</span>
    </a>
    <ul class="nav submenu">
      <li><a href="product.php">Manage product</a> </li>
      <li><a href="add_product.php">Add product</a> </li>
    </ul>
  </li> 
  <li>
    <a href="media.php">
      <i class="glyphicon glyphicon-picture"></i>
      <span>Media</span>
    </a>
  </li>-->
</ul>
<script>$(document).ready(function () {
    function low_stock_alert() {
      $.ajax({
        type: "GET",
        url: "../low_stock/stock_alert.php", success: function (response) {
          console.log(response);
          var requestAlert = JSON.parse(response).alertCount;
          console.log(requestAlert);
          $("#request_alert").text(requestAlert);
        }
      });
    }
    setInterval(low_stock_alert, 20000);</script>
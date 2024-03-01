<?php
$page_title = 'View low stocks';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
//$po_histories = find_po_history();
$suppliers = find_all('supplier');
$stocks = low_stock();
$count = count_cart_items('po_items', 'list_id');
?>
<?php
include_once('../layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">

                <div id="viewBtn" class="pull-right">
                    <a href="make_purchase.php" class="btn btn-success">VIEW (
                        <?php echo $count ?>)
                    </a>
                    <a href="clear.php" class="btn btn-danger">CLEAR (
                        <?php echo $count ?>)
                    </a>
                    <!-- <a href="purchase_order.php" class="btn btn-info pull-right btn-sm">Create new</a> -->
                </div>

                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Low Stocks</span>
                </strong>

            </div>
            <div class=" panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center" style="width: 50px;">Item Code</th>
                            <th class="text-center" style="width: 50px;">Supplier</th>
                            <th class="text-center" style="width: 50px;">Threshold</th>
                            <th class="text-center" style="width: 50px;">Cost</th>
                            <th class="text-center" style="width: 50px;">Qty</th>
                            <th class="text-center" style="width: 5%;">Unit</th>
                            <th class="text-center" style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="low_stocks">
                        <?php foreach ($stocks as $stock): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo count_id(); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $stock['prod_code'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $stock['COMPANY_NAME'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $stock['low_stock'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $stock['buy_price'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $stock['unit'] ?>
                                </td>
                                <td class="text-center"><input type='number' class='qty' value='1' min='1'>
                                </td>
                                <td class="text-center"><button class='btn btn-primary add_button'
                                        data-id='<?php echo $stock['prod_id'] ?>'>Add</button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // function retrieveItems() {
        //     $.ajax({
        //         url: "retrieve_low_stocks.php",
        //         type: "GET",
        //         success: function (response) {
        //             console.log("Response:", response);
        //             displayItems(response);
        //         }
        //     });
        // }
        // function displayItems(items) {
        //     $("#low_stocks").empty();
        //     items.forEach(function (item) {
        //         $("#low_stocks").append(

        //         );
        //     });
        // }
        // setInterval(retrieveItems, 4000);
        $(document).on('click', '.add_button', function () {
            var itemId = $(this).data('id');
            var quantity = $('.qty').val();
            console.log("Item ID:", itemId, "Quantity:", quantity);
            var data = {
                'id': itemId,
                'quantity': quantity
            }

            $.ajax({
                type: "POST",
                url: "add_po_items.php",
                data: data,
                // dataType: 'json',
                success: function (response) {
                    var itemCount = JSON.parse(response).itemCount;
                    $("#itemCount").text(itemCount);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    });
</script>
<?php include_once('../layouts/footer.php'); ?>
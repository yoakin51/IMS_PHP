<?php
$page_title = 'Purchase Orders';
require_once('../includes/load.php');
page_require_level(2);
//fetch new requests

$uid = $_SESSION['user_id'];
if(isset($_GET['po_id'])){

}
if (isset($_POST['purchase-btn'])) {
    $supplier = $_POST['supplier'];
    $total_cost = $_POST['totalcost'];
    $amount = $_POST['amount'];
    $remark = $_POST['remark'];

    $sql = "INSERT INTO purchase_order(";
    $sql .= "supplier_id,total_cost,amount,remarks) VALUES ( ";
    $sql .= "$supplier,$total_cost,$amount,'$remark')";
    
    $db->query($sql);
    $po_id = $db->insert_id();
    $cart = "UPDATE po_items SET po_id=$po_id, item_status=1;";
    if ($db->query($cart)) {
        $session->msg('s', "Order submitted. ");
        redirect('order_list.php', true);
    } else {
        $session->msg('d', ' Sorry failed to submit request!');
        redirect('order_list.php', false);
    }
}
$carts = po_items_in_cart();
$count = count_cart_items('po_items', 'list_id');
$suppliers = find_all('supplier');
?>
<?php
include_once('../layouts/header.php'); ?>

<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class=" row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Make Purchase Order</span>
                </strong>
                <div class="btn-group pull-right">
                    <a href="low_stocks.php" class="btn btn-warning">Edit </a>
                </div>
            </div>
            <form action=" make_purchase.php" method="post">
                <div class="panel-body">
                    <table class="table table-bordered ">
                        <fieldset>
                            <legend>Information</legend>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="supplier">Select Supplier</label>
                                    <select class="form-control" name="supplier" required>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <option value="<?php echo $supplier['SUPPLIER_ID']; ?>">
                                                <?php echo ucwords($supplier['COMPANY_NAME']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="remark">Remark</label>
                                    <textarea class="form-control" name="remark" id="" cols="" rows="4"
                                ></textarea>
                                </div>
                            </div>
                            <br>
                        </fieldset>
                        <br><br>
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th class="text-center" style="width: 15%;"> Product name </th>
                                <th class="text-center" style="width: 15%;"> Product Code </th>
                                <th class="text-center" style="width: 7%;"> Unit Cost(ETB)</th>
                                <th class="text-center" style="width: 7%;">Quantity</th>

                                <th class="text-center" style="width: 7%;"> TOTAL(ETB)</th>
                                <th class="text-center" style="width: 5%;"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php global $costSum;
                            global $itemSum;
                            ?>
                            <?php foreach ($carts as $cart): ?>
                                <?php $item_id = $cart['item_id'];
                                $itemSum += $cart['quantity'];
                                ?>

                                <tr>
                                    <td class="text-center">
                                        <?php echo count_id(); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo remove_junk($cart['prod_name']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo remove_junk($cart['prod_code']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo remove_junk($cart['buy_price']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo (int) $cart['quantity'] . " " . $cart['unit']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $price = $cart['buy_price'];
                                        $qty = $cart['quantity'];
                                        $total = $price * $qty;
                                        echo $total;
                                        $costSum += $total;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">

                                            <a class=" btn btn-xs btn-danger"
                                                href="removeFromCart.php?list_id=<?php echo (int) $cart['list_id']; ?>"><i
                                                    class="glyphicon glyphicon-remove"></i></a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right py-1 px-2" colspan="4">Sub Total </th>
                                <th class=" text-center py-1 px-2" colspan="1">
                                    <input type="text"class="text-center"  name="totalcost" value=" <?php echo $itemSum; ?>" readonly>
                                </th>
                                <th class=" text-center py-1 px-2" colspan="1">
                                    <input type="text" class="text-center" name="amount" value=" <?php echo $costSum; ?>"
                                        readonly>
                                </th>

                            </tr>
                            <tfoot>
                    </table>
                    <div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success " name=" purchase-btn">Make
                                Order
                                (
                                <?php echo $count; ?>)
                            </button>
                        </div>


                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div id=" modal5" class="modal-container">
    <div class="modal-content" id="modalContent-5">

        <!-- Content for Modal 5 -->


    </div>
</div>
<!-- <script>
    $(document).ready(function () {
        $('.remove').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "../request/removeFromCart.php",
                data: {
                    id: id,
                    table: 'po_items'
                },
                success: function (result) {
                    location.reload();
                }
            });
        });
    });
</script> -->
<?php include_once('../layouts/footer.php'); ?>
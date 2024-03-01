<?php
$page_title = 'Item List';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
//fetch new requests
$uid = $_SESSION['user_id'];
if (isset($_POST['request'])) {
    $sql = "INSERT INTO store_requisitions(";
    $sql .= "item_id, user_id, qty, item_code, measurement, item_name) ";
    $sql .= "SELECT c.prod_id, c.user_id, c.quantity, p.prod_code, p.unit, p.prod_name ";
    $sql .= "FROM cart c ";
    $sql .= "JOIN products p ON c.prod_id = p.prod_id ";
    $sql .= "WHERE user_id = $uid";
    if ($db->query($sql)) {
        $session->msg('s', "request submitted. ");
        $delete = "DELETE FROM cart WHERE user_id = $uid";
        $db->query($delete);
        redirect('product_list.php', true);
    } else {
        $session->msg('d', ' Sorry failed to submit request!');
        redirect('product_list.php', false);
    }
}
$carts = items_in_cart();
$count = count_items('cart');
?>
<?php
include_once('../layouts/header.php'); ?>

<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="btn-group">
    <a href="product_list.php">Edit </a>
</div>
<div class=" row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Store Requisition</span>
                </strong>

            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Product name </th>
                            <th class="text-center" style="width: 7%;"> Quantity</th>
                            <th class="text-center" style="width: 15%;"> Total </th>
                            <th class="text-center" style="width: 15%;"> Requested by </th>
                            <th class="text-center" style="width: 15%;"> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carts as $cart): ?>
                            <?php $item_id = $cart['item_id']; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo ($cart['item_id']); ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($cart['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (int) $cart['quantity'] . " " . $cart['unit']; ?>
                                </td>
                                <td class="text-center">
                                    <?php $price = $cart['buy_price'];
                                    $qty = $cart['quantity'];
                                    $total = $price * $qty;
                                    echo $total;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($cart['name']); ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class=" btn btn-xs btn-danger"
                                            data-id="<?php echo (int) $cart['item_id']; ?>" id="remove">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div>
                    <form action="item_list.php" method="post">
                        <button type="submit" name="request">Make request
                            (
                            <?php echo $count; ?>)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id=" modal5" class="modal-container">
    <div class="modal-content" id="modalContent-5">

        <!-- Content for Modal 5 -->


    </div>
</div>
<script>
    $(document).ready(function () {
        $('#remove').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "removeFromCart.php",
                data: { id: id },
                success: function (result) {
                    location.reload();
                }
            });
        });
    });
</script>
<?php include_once('../layouts/footer.php'); ?>
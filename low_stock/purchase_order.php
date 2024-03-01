<?php
$page_title = 'purchaseOrder';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$suppliers = find_all('supplier');
$po_histories = find_po_history();
?>
<?php
if (isset($_POST['make_order'])) {

    $req_fields = array('supplier_id', 'item_code', 'quantity', 'measurement', 'unit_price', 'delivery_date');
    validate_fields($req_fields);

    if (empty($errors)) {
        $supplier_id = remove_junk($db->escape($_POST['supplier_id']));
        $code = remove_junk($db->escape($_POST['item_code']));
        $quantity = remove_junk($db->escape($_POST['quantity']));
        $measurement = remove_junk($db->escape($_POST['measurement']));
        $unit_price = remove_junk($db->escape($_POST['unit_price']));
        $total_price = $unit_price * $quantity;
        $delivery_date = remove_junk($db->escape($_POST['delivery_date']));
        $transaction_id = generateTransactionId();
        $current_date = getCurrentDate();
        $item_name = find_product_by_code($code);
        $sname = find_supplier_info($supplier_id);
        $man_id = $_SESSION['user_id'];
        $mname = find_user_info($man_id);

        $query = "INSERT INTO purchase_order (";
        $query .= "po_supplier,po_item_code,po_qty,unit_measure,unit_price,total_price,po_approved,transac_id";
        $query .= ") VALUES (";
        $query .= " '{$supplier_id}', '{$code}', '{$quantity}', '{$measurement}','{$unit_price}', '{$total_price}', '{$man_id}','{$transaction_id}'";
        $query .= ")";




        if ($db->query($query)) {
            header("Location: po_preview.php?&current_date=$current_date&SUP_NAME=$sname&supplier_id=$supplier_id&item_code=$code&quantity=$quantity&measurement=$measurement&unit_price=$unit_price&total=$total_price&delivery_date=$delivery_date&MAN_NAME=$mname&man_id=$man_id&transaction_id=$transaction_id&item_name=$item_name");
        } else {
            //failed
            $session->msg('d', ' Sorry failed to make purchase order');
            redirect('purchase_order.php', false);
        }




    }

} else {
    $session->msg("d", $errors);
    // redirect('home.php', false);
}

?>

<?php include_once('../layouts/header.php'); ?>
<?php echo display_msg($msg);
?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Make purchase order</span>

            </strong>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <form method="post" action="purchase_order.php">
                    <div class="form-group">
                        <label for="level">Supplier</label>
                        <select class="form-control" name="supplier_id" required>
                            <?php foreach ($suppliers as $supplier): ?>
                                <option value="<?php echo $supplier['SUPPLIER_ID']; ?>">
                                    <?php echo ucwords($supplier['COMPANY_NAME']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item_code">Item code</label>
                        <input type="text" class="form-control" name="item_code" placeholder="item code" required>
                    </div>
                    <div class="form-group" style="display:flex;">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" min="1" name="quantity" id="quantity"
                            placeholder="quantity" required>
                        <select class="form-control" style="width:100px;" name="measurement">
                            <option value="kg">killo-grams</option>
                            <option value="g">grams</option>
                            <option value="dozens">dozens</option>
                            <option value="bale">bales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="unit_price">Unit price</label>
                        <input type="number" class="form-control" id="price" step="0.01" name="unit_price"
                            placeholder="unit_price(ETB)" required>
                    </div>

                    <div class="form-group">
                        <label for="delivery_date">Delivery date</label>
                        <input type="date" class="form-control" name="delivery_date" required>
                    </div>




                    <div class="form-group clearfix">
                        <button type="submit" name="make_order" class="btn btn-primary">make order</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Purchase Orders history</span>
                </strong>

            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">P.O.ID</th>
                            <th> Product name </th>
                            <th class="text-center" style="width: 7%;">Code</th>
                            <th class="text-center" style="width: 7%;"> Quantity</th>
                            <th class="text-center" style="width: 15%;"> Price </th>
                            <th class="text-center" style="width: 15%;">Supplier</th>
                            <th class="text-center" style="width: 15%;"> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($po_histories as $po_history): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo ($po_history['transac_id']); ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($po_history['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $po_history['po_item_code']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (int) $po_history['po_qty'] . $po_history['unit_measure']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($po_history['total_price']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($po_history['COMPANY_NAME']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $po_history['po_date']; ?>
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
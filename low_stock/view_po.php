<?php
$page_title = 'Purchase Orders';
require_once('../includes/load.php');
page_require_level(2);
//fetch new requests

$uid = $_SESSION['user_id'];
if (isset($_GET['po_id'])) {
    $po_id = $_GET['po_id'];

    $carts = find_po_by_id($po_id);
    $suppliers = find_all('supplier');
    $outer = find_two_($po_id);
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
                        <h1>NAZMENTORY</h1>
                        <span>PURCHASE ORDER </span>
                    </strong>

                </div>
                <?php ;
                foreach ($outer as $out):
                    ?>


                    <div class="panel-body">
                        <table class="table table-bordered ">
                            <fieldset>
                                <legend>Information<h2 class="pull-right"> PO-ID: PO-
                                        <?php echo $out['po_id']; ?>
                                    </h2>
                                </legend>

                                <div class="form-group">
                                    <div>

                                        <h4 class="pull-right">Date:

                                            <?php echo $out['date_created']; ?>
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="supplier">Select Supplier</label>
                                        <select class="form-control" name="supplier" required>
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?php echo $out['supplier_id']; ?>">
                                                    <?php echo $out['COMPANY_NAME']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    

                              
                    </div>
                    <br>
                    </fieldset>
                    <br><div>
                        <label for="remark">Remark</label>
                                    <p>     <?php echo $out['remarks']; ?>
                                    </p></div><br>
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-center" style="width: 15%;"> Product name </th>
                            <th class="text-center" style="width: 15%;"> Product Code </th>
                            <th class="text-center" style="width: 7%;"> Unit Cost(ETB)</th>
                            <th class="text-center" style="width: 7%;">Quantity</th>

                            <th class="text-center" style="width: 7%;"> TOTAL(ETB)</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carts as $cart): ?>

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
                                    <?php echo (int) $cart['po_quantity'] . " " . $cart['unit']; ?>
                                </td>
                                <td class="text-center">
                                    <?php $price = $cart['buy_price'];
                                    $qty = $cart['po_quantity'];
                                    $total = $price * $qty;
                                    echo $total;

                                    ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right py-1 px-2" colspan="4">Sub Total </th>
                            <th class=" text-center py-1 px-2" colspan="1">
                                <input type="text" class="text-center" name="totalcost" value=" <?php echo $out['amount']; ?>"
                                    readonly>
                            </th>
                            <th class=" text-center py-1 px-2" colspan="1">
                                <input type="text" class="text-center" name="amount" value=" <?php echo $out['total_cost']; ?>"
                                    readonly>
                            </th>

                        </tr>
                        </tfoot>
                            </table>
                            <!-- <div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success " onclick="window.print()"
                                        name=" purchase-btn">Print
                                    </button>
                                </div>


                            </div> -->
                </div>

            <?php endforeach ?>
        </div>
    </div>
    </div>
    <?php
} else {
    $session->msg('d', ' Sorry missing order!');
    redirect('order_list.php', false);
} ?>

<?php include_once('../layouts/footer.php'); ?>
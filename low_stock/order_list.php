<?php
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
$pos = find_all('purchase_order');
?>
<?php include_once('../layouts/header.php'); ?>


<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row ">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Groups</span>
                </strong>
                <div class=" panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>

                                <th> Date created</th>
                                <th class="text-center" style="width: 10%;"> P.O Code</th>
                                <th class="text-center" style="width: 10%;"> Items</th>
                                <th class="text-center" style="width: 10%;"> Cost</th>
                                <th class="text-center" style="width: 5%;"> Status</th>
                                <th class="text-center" style="width: 100px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pos as $po): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo count_id(); ?>
                                    </td>
                                    <td>
                                        <?php echo remove_junk($po['date_created']); ?>
                                    </td>
                                    <td class="text-center">PO-
                                        <?php echo remove_junk($po['po_id']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo remove_junk($po['amount']); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo remove_junk($po['total_cost']); ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($po['status'] === 1) {
                                            ?>
                                            <span class="badge alert-success">Recieved</span>
                                        <?php } else {
                                            ?><span class="badge alert-warning">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="view_po.php?po_id=<?php echo $po['po_id']; ?>"> <span
                                                            class="glyphicon glyphicon-eye-open"></span> View</a>
                                                </li>
                                                <li><a href="delete_order.php?po_id=<?php echo $po['po_id']; ?>"> <span
                                                            class="glyphicon glyphicon-trash"></span>
                                                        Delete</a>
                                                </li>
                                                <li><a href="receive.php?po_id=<?php echo $po['po_id']; ?>">
                                                        <span class="glyphicon glyphicon-list-alt"></span>
                                                        Receive</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- </form>-->
                </div>
            </div>

        </div>
    </div>
</div>
<div>
</div>
<?php include_once('../layouts/footer.php'); ?>
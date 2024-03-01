<?php
$page_title = 'View requisitions';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);

$histories = find_issue_history();
?>

<?php include_once('../layouts/header.php'); ?>


<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Issue Voucher History</span>
                </strong>
                <div class="pull-right">
                    <a href="request.php" class="btn btn-primary">Add request</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Product name </th>
                            <th class="text-center" style="width: 7%;"> Quantity</th>
                            <th class="text-center" style="width: 15%;"> Total </th>
                            <th class="text-center" style="width: 15%;"> Requested by </th>
                            <th class="text-center" style="width: 150px;"> Department </th>
                            <th class="text-center" style="width: 15%;"> Date </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($histories as $history): ?>
                            <?php $request_id = $history['request_id']; ?>
                            <tr class="openModalBtn" data-value="<?php echo $request_id ?>" data-modal-id="4"
                                data-url="../modals/issue_history_modal.php">
                                <td class="text-center">
                                    <?php echo count_id(); ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($history['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (int) $history['qty']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($history['buy_price']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($history['name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($history['department']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $history['timestamp']; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal4" class="modal-container">
    <div class="modal-content" id="modalContent-4">
        <!-- Content for Modal 1 -->
    </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
<?php
$page_title = 'Requisitions History';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
//fetch new requests
$histories = find_request_history();
?>
<?php
include_once('../layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Request history</span>
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
                            <th class="text-center" style="width: 15%;"> Department </th>
                            <th class="text-center" style="width: 15%;"> Requested by </th>
                            <th class="text-center" style="width: 15%;"> Date </th>
                            <th class="text-center" style="width: 15%;"> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($histories as $history): ?>
                            <?php $request_id = $history['request_id']; ?>
                            <tr class="openModalBtn" data-value="<?php echo $request_id ?>" data-modal-id="2"
                                data-url="../modals/req_history_modal.php">
                                <td class="text-center">
                                    <?php echo ($history['request_id']); ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($history['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (int) $history['qty'] . " " . $history['measurement']; ?>
                                </td>
                                <td class="text-center">
                                    <?php $price = $history['buy_price'];
                                    $qty = $history['qty'];
                                    $total = $price * $qty;
                                    echo $total;
                                    ?>

                                </td>
                                <td class="text-center">

                                    <?php echo remove_junk($history['department']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($history['name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $history['timestamp']; ?>
                                </td>
                                <td class="text-center">

                                    <?php
                                    if ($history['approved_by'] == $_SESSION['user_id']) {
                                        echo '<strong class="success">APPROVED</strong>';
                                    } else if ($history['approved_by'] == 'Declined') {
                                        echo '<strong class="danger">DENIED</strong>';
                                    }
                                    ?>

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
<!-- Modal -->
<div id="modal2" class="modal-container">
    <div class="modal-content" id="modalContent-2">

        <!-- Content for Modal 1 -->


    </div>
</div>
<?php include_once('../layouts/footer.php'); ?>
<?php
$page_title = 'Requesters History';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
//fetch new requests

if (isset($_GET['request_id'])) {

    $req_id = $_GET['request_id'];
    $confirmed = confirm_issue($req_id, $_SESSION['user_id']);
    if ($confirmed == true) {
        $session->msg("s", 'Store issue has been confirmed!');
        redirect('requester_history.php');
    } else {
        $session->msg("d", 'System could not carry out the task!');
        redirect('requester_history.php');
    }


}

$histories = find_my_request_history();

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
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>My Request history</span>
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
                            <tr class="openModalBtn" data-value="<?php echo $request_id ?>" data-modal-id="5"
                                data-url="../modals/issue_confirmation_modal.php">
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
                                    if ($history['issued_by'] !== null && $history['issued_by'] !== 'Declined' && $history['confirmed'] === null) {
                                        echo '<strong class="warning">CONFIRM</strong>';

                                    } elseif ($history['approved_by'] === 'Declined' && $history['confirmed'] === null) {
                                        echo '<strong class="danger">DENIED by manager</strong>';
                                    } else if ($history['issued_by'] === 'Declined' && $history['confirmed'] === null) {
                                        echo '<strong class="danger">DENIED by store</strong>';
                                    } elseif ($history['issued_by'] === null && $history['confirmed'] === null) {
                                        echo '<strong class="warning">PENDING...</strong>';
                                    } elseif ($history['confirmed'] !== NULL) {
                                        echo '<strong class="warning">CONFIRMED</strong>';
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
<div id="modal5" class="modal-container">
    <div class="modal-content" id="modalContent-5">

        <!-- Content for Modal 5 -->


    </div>
</div>
<?php include_once('../layouts/footer.php'); ?>
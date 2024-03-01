<?php
$page_title = 'View requisitions';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);


if (isset($_GET['request_id'])) {

    $response = $_GET['request_id'];
    $req_id = substr($response, 0);
    $status = substr($response, -1);
    if ($status == 'I') {
        $approved = issue($req_id, $_SESSION['user_id']);
        if ($approved == true) {
            $session->msg("s", 'Request has been Issued!');
            redirect('view_requisitions.php');
        } else if ($approved == false) {
            $session->msg("d", 'Sorry!! you are low on this stock!');
            redirect('view_requisitions.php');
        }

    } elseif (substr($status, -1) == 'D') {
        $declined = decline_issue($req_id);
        if ($declined == true) {
            $session->msg("s", 'Request has been declined!');
            redirect('view_requisitions.php');
        } else {
            $session->msg("d", 'System could not carry out the task!');
            redirect('view_requisitions.php');
        }
    }

} else {
    $session->msg("d", $errors);
    // redirect('home.php', false);
}
?>


<?php
$requests = view_all_approved_request();
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
                    <span>All Requests</span>
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
                        <?php foreach ($requests as $request): ?>
                            <?php $request_id = $request['request_id']; ?>
                            <tr class="openModalBtn" data-value="<?php echo $request_id ?>" data-modal-id="3"
                                data-url="../modals/approved_req_modal.php">
                                <td class="text-center">
                                    <?php echo count_id(); ?>
                                </td>
                                <td>(
                                    <?php echo $request_id; ?>)
                                    <?php echo remove_junk($request['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (int) $request['qty']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($request['buy_price']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($request['name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($request['department']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $request['timestamp']; ?>
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
<div id="modal3" class="modal-container">
    <div class="modal-content" id="modalContent-3">
        <!-- Content for Modal 1 -->
    </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
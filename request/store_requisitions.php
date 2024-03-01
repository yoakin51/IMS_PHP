<?php
$page_title = 'All requisitions';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);


?>

<?php
$requests = find_store_requisitions();
$histories = find_requisitions_history();
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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Product name </th>
                            <th class="text-center" style="width: 7%;"> Quantity</th>
                            <th class="text-center" style="width: 15%;"> Total </th>
                            <th class="text-center" style="width: 15%;"> Requested by </th>
                            <th class="text-center" style="width: 15%;"> Date </th>
                            <th class="text-center" style="width: 150px;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo count_id(); ?>
                                </td>
                                <td>
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
                                    <?php echo $request['timestamp']; ?>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group">
                                        <form method="POST" id="approval_form" class="form-in-line">

                                            <input type="hidden" name="request_id" id="request_id"
                                                value="<?php echo $request['request_id'] ?>">

                                            <button type="submit" class="btn btn-success btn-xs" name="approve"
                                                id="approve">Approve</button>

                                        </form>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
                            <th class="text-center" style="width: 15%;"> Requested by </th>
                            <th class="text-center" style="width: 15%;"> Date </th>
                            <th class="text-center" style="width: 150px;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($histories as $history): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo ($history['request_id']); ?>
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
                                    <?php echo $history['timestamp']; ?>
                                </td>
                                <td class="text-center">

                                    <?php
                                    if ($history['approved_by'] == $_SESSION['user_id']) {
                                        echo '<strong>APPROVED</strong>';
                                    } else if ($history['approved_by'] == 'denied') {
                                        echo '<strong>DENIED</strong>';
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

<?php include_once('../layouts/footer.php'); ?>
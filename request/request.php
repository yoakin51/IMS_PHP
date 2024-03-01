<?php
$page_title = 'Store Requisition';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3); //if user_level is greater than or equal return true
?>
<?php
$u_id = $_SESSION['user_id'];

if (isset($_POST['request'])) {
    $req_fields = array('item_id', 'quantity', 'item_name', 'item_code', 'measurement');
    validate_fields($req_fields);
    if (empty($errors)) {
        $i_id = $db->escape((int) $_POST['item_id']);
        $qty = $db->escape((int) $_POST['quantity']);
        $i_name = $db->escape($_POST['item_name']);
        $i_code = $db->escape($_POST['item_code']);
        $measurement = $db->escape($_POST['measurement']);



        $sql = "INSERT INTO store_requisitions (";
        $sql .= " item_id,user_id,qty,item_code,measurement,item_name";
        $sql .= ") VALUES (";
        $sql .= "'{$i_id}','{$u_id}','{$qty}','{$i_code}','{$measurement}','{$i_name}'";
        $sql .= ")";

        if ($db->query($sql)) {
            //  update_product_qty($qty, $i_id);
            $session->msg('s', "Request submitted. ");
            redirect('request.php', false);
        } else {
            $session->msg('d', ' Sorry failed to submit request!');
            redirect('request.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('request.php', false);
    }
}

?>
<?php include_once('../layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Find It</button>
                    </span>
                    <input type="text" id="sug_input" class="form-control" name="title"
                        placeholder="Search for product name">
                </div>
                <div id="result" class="list-group"></div>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Make store requisition</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="request.php">
                    <table class="table table-bordered">
                        <thead>
                            <th> Item </th>
                            <th> Qty </th>
                            <th> Unit </th>
                            <th> Action</th>
                        </thead>
                        <tbody id="product_info"> </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once('../layouts/footer.php'); ?>
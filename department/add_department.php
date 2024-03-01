<?php
$page_title = 'Add Department';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
if (isset($_POST['add-dep'])) {

    $req_fields = array('dep-name', 'dep-head');
    validate_fields($req_fields);

    if (find_by_depName($_POST['dep-name']) === false) {
        $session->msg('d', '<b>Sorry!</b> Entered Department Name already in database!');
        redirect('add_deparment.php', false);
    } elseif (find_dep_head($_POST['dep-head']) === false) {
        $session->msg('d', '<b>Sorry!</b> Entered ID already in database!');
        redirect('add_department.php', false);
    }
    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['dep-name']));
        $head = remove_junk($db->escape($_POST['dep-head']));
        $status = remove_junk($db->escape($_POST['status']));

        $query = "INSERT INTO departments (";
        $query .= "dep_name,dep_head,dep_status";
        $query .= ") VALUES (";
        $query .= " '{$name}', '{$head}','{$status}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', "Department has been created! ");
            redirect('add_department.php', false);
        } else {
            //failed
            $session->msg('d', ' Sorry failed to create Group!');
            redirect('add_department.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_department.php', false);
    }
}
?>
<?php include_once('../layouts/header.php'); ?>
<div class="main-content-container">
    <div class="main-content">
        <div class="login-page">
            <div class="text-center">
                <h3>Add new Department</h3>
            </div>
            <?php echo display_msg($msg); ?>
            <form method="post" action="add_department.php" class="clearfix">
                <div class="form-group">
                    <label for="name" class="control-label">Department Name</label>
                    <input type="name" class="form-control" name="dep-name">
                </div>
                <div class="form-group">
                    <label for="level" class="control-label">Department Head ID No.</label>
                    <input type="number" class="form-control" name="dep-head">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
                <div class="form-group clearfix">
                    <button type="submit" name="add-dep" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>

        <?php include_once('../layouts/footer.php'); ?>
    </div>
</div>
<?php
$page_title = 'Edit Department';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
$e_group = find_dep_by_id((int) $_GET['dep_id']);
if (!$e_group) {
    $session->msg("d", "Missing Department id.");
    redirect('departments.php');
}
?>
<?php
if (isset($_POST['dep-update'])) {

    $req_fields = array('dep-name', 'dep-head');
    validate_fields($req_fields);
    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['dep-name']));
        $head = remove_junk($db->escape($_POST['dep-head']));
        $status = remove_junk($db->escape($_POST['status']));

        $query = "UPDATE departments SET ";
        $query .= "dep_name='{$name}',dep_head='{$head}',dep_status='{$status}'";
        $query .= "WHERE dep_id='{$db->escape($e_group['dep_id'])}'";
        $result = $db->query($query);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', "Department has been updated! ");
            redirect('edit_department.php?dep_id=' . (int) $e_group['dep_id'], false);
        } else {
            //failed
            $session->msg('d', ' Sorry failed to updated Department!');
            redirect('edit_department.php?dep_id=' . (int) $e_group['dep_id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_department.php?dep_id=' . (int) $e_group['dep_id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="main-content-container">
    <div class="main-content">
        <div class="login-page">
            <div class="text-center">
                <h3>Edit Department</h3>
            </div>
            <?php echo display_msg($msg); ?>
            <form method="post" action="edit_department.php?dep_id=<?php echo (int) $e_group['dep_id']; ?>"
                class="clearfix">
                <div class="form-group">
                    <label for="name" class="control-label">Department Name</label>
                    <input type="name" class="form-control" name="dep-name"
                        value="<?php echo remove_junk(ucwords($e_group['dep_name'])); ?>">
                </div>
                <div class="form-group">
                    <label for="level" class="control-label">Department Head</label>
                    <input type="number" class="form-control" name="dep-head"
                        value="<?php echo (int) $e_group['dep_head']; ?>">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status">
                        <option <?php if ($e_group['dep_status'] === '1')
                            echo 'selected="selected"'; ?> value="1"> Active
                        </option>
                        <option <?php if ($e_group['dep_status'] === '0')
                            echo 'selected="selected"'; ?> value="0">
                            Deactive
                        </option>
                    </select>
                </div>
                <div class="form-group clearfix">
                    <button type="submit" name="dep-update" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>

        <?php include_once('../layouts/footer.php'); ?>
    </div>
</div>
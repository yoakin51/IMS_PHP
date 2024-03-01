<?php
$page_title = 'All Departments';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$all_groups = find_all('departments');
?>
<?php include_once('../layouts/header.php'); ?>

<!--<div class="main-content">-->
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Departments</span>
                </strong>
                <a href="add_department.php" class="btn btn-info pull-right btn-sm"> Add New Department</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Department Name</th>
                            <th class="text-center" style="width: 20%;">Department Head</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_groups as $a_group): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_group['dep_id'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_group['dep_name'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_group['dep_head'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($a_group['dep_status'] === '1'): ?>
                                        <span class="label label-success">
                                            <?php echo "Active"; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="label label-danger">
                                            <?php echo "Deactive"; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_department.php?dep_id=<?php echo (int) $a_group['dep_id']; ?>"
                                            class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_department.php?dep_id=<?php echo (int) $a_group['dep_id']; ?>"
                                            class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
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
<!--< /div>-->

<script>
    $(document).ready(function () {
        // Click event for sidebar links
        $('.sidebar-link').click(function (event) {
            event.preventDefault(); // Prevent default link behavior

            var url = $(this).data('url'); // Get the URL from data attribute
            var mainContent = $('.main-content'); // Find the main content area

            // Load content using AJAX
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    // Replace main content with the loaded content
                    mainContent.html(response);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<?php include_once('../layouts/footer.php'); ?>
<?php
//insert.php
require_once("../includes/load.php");

if (isset($_POST['request_id'])) {

    $request_id = $_POST['request_id'];
    $manager_id = $_POST['manager_id'];

    approve_request($request_id, $manager_id);
}
?>
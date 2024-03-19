<?php
ob_start(); //data form backend is stored on internal buffer
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) { //if user is not logged in redirect user to home temporarily
  redirect('dashboard/home.php', false);
}
?>
<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>
    <?php if (!empty($page_title))
      echo remove_junk($page_title);
    elseif (!empty($user))
      echo ucfirst($user['name']);
    else
      echo "Inventory Management System"; ?>
  </title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <link rel="stylesheet" href="libs/css/main.css" />
</head>

<body class="bgimage">



  <div class="page">
    <div class="container-fluid">
      <div class="login-page">
        <div class="text-center">
          <h1>Login Panel</h1>
          <h4>Nazmentory</h4>
        </div>
        <?php
//echo out image
echo display_msg($msg); ?>
        <form method="post" action="settings/auth.php" class="clearfix">
          <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="name" class="form-control" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="libs/js/functions.js"></script>







</body>

</html>

<?php if (isset($db)) {
  $db->db_disconnect();
} ?>

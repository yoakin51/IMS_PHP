<?php
$page_title = 'Add Product';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
$all_categories = find_all('categories');
$all_photo = find_all('media');
?>
<?php
if (isset($_POST['add_product'])) {
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'unit', 'p_code');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_name = remove_junk($db->escape($_POST['product-title']));
    $p_cat = remove_junk($db->escape($_POST['product-categorie']));
    $p_qty = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy = remove_junk($db->escape($_POST['buying-price']));
    $p_unit = remove_junk($db->escape($_POST['unit']));
    $p_code = remove_junk($db->escape($_POST['p_code']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $date = make_date();
    $query = "INSERT INTO products (";
    $query .= " prod_name,prod_code,quantity,buy_price,unit,categorie_id,media_id,date";
    $query .= ") VALUES (";
    $query .= " '{$p_name}','{$p_code}', '{$p_qty}', '{$p_buy}', '{$p_unit}', '{$p_cat}', '{$media_id}', '{$date}'";
    $query .= ")";
    $query .= " ON DUPLICATE KEY UPDATE prod_name='{$p_name}'";
    if ($db->query($query)) {
      $session->msg('s', "Product added ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d', ' Sorry failed to added!');
      redirect('product.php', false);
    }

  } else {
    $session->msg("d", $errors);
    redirect('add_product.php', false);
  }

}

?>
<?php include_once('../layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Product</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i>
                    </span>
                    <input type="text" class="form-control" name="product-title" placeholder="Product Title" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <select class="form-control" name="product-categorie" required>
                    <option value="">Select Product Category</option>
                    <?php foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int) $cat['id'] ?>">
                        <?php echo $cat['name'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <input type="text" class="form-control" name=" p_code" placeholder="Product code" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                    </span>
                    <input type="number" class="form-control" min="1" name="product-quantity"
                      placeholder="Product Quantity" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="numbers" class="form-control" min="0" name=" buying-price" placeholder="cost" required>
                  </div>
                </div>
                <!-- <div class="col-md-4">
                  <select class="form-control" name="product-photo">
                    <option value="">Select Product Photo</option>
                    <?php foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int) $photo['id'] ?>">
                        <?php echo $photo['file_name'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
              </div>-->
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-stats"></i>
                    </span>
                    <select class="form-control" name="unit" id="unit" required>
                      <option value=" ">Select measurement unit</option>
                      <option value=" KG">kg</option>
                      <option value="grams">grams</option>
                      <option value="bale">bale</option>
                      <option value="units">units</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
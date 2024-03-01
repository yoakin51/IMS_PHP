<?php
$page_title = 'Edit product';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php
$p_id = $_GET['prod_id'];
$product = find_products_by_id($p_id);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if (!$product) {
  $session->msg("d", "Missing product id.");
  redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'code', 'low_stock', 'over_stock', 'unit');
  validate_fields($req_fields);

  if (empty($errors)) {
    $p_name = remove_junk($db->escape($_POST['product-title']));
    $p_cat = (int) $_POST['product-categorie'];
    $p_qty = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy = remove_junk($db->escape($_POST['buying-price']));
    $p_code = remove_junk($db->escape($_POST['code']));
    $over = remove_junk($db->escape($_POST['over_stock']));
    $low = remove_junk($db->escape($_POST['low_stock']));
    $unit = remove_junk($db->escape($_POST['unit']));

    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $query = "UPDATE products SET ";
    $query .= "prod_code = '{$p_code}', prod_name ='{$p_name}', quantity ='{$p_qty}',";
    $query .= " buy_price ='{$p_buy}', categorie_id ='{$p_cat}',media_id='{$media_id}',unit='{$unit}',low_stock='{$low}',over_stock='{$over}'";
    $query .= " WHERE prod_id ='{$product[0]['prod_id']}'";
    $result = $db->query($query);
    if ($result && $db->affected_rows() === 1) {
      $session->msg('s', "Product updated ");
      redirect('product.php', false);
    } else {
      $session->msg('d', ' Sorry failed to updated!');
      redirect('edit_product.php?prod_id=' . $product[0]['prod_id'], false);
    }

  } else {
    $session->msg("d", $errors);
    redirect('edit_product.php?prod_id=' . $product[0]['prod_id'], false);
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
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit-Product</span>
      </strong>
    </div>
    <div class="panel-body">

      <div class="col-md-12">
        <form method="post" action="edit_product.php?prod_id=<?php echo $product[0]['prod_id']; ?>">
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title"
                    value="<?php echo remove_junk($product[0]['prod_name']); ?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" class="form-control" name="code" placeholder="Item_code"
                    value="<?php echo remove_junk($product[0]['prod_code']); ?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="number" class="form-control" name="low_stock" placeholder="low stock alert limit..."
                    value="<?php echo remove_junk($product[0]['low_stock']); ?>" required>
                </div>
              </div>

            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select class="form-control" name="product-categorie" required>
                  <option value=""> Select a categorie</option>
                  <?php foreach ($all_categories as $cat): ?>
                    <option value="<?php echo (int) $cat['id']; ?>" <?php if ($product[0]['categorie_id'] === $cat['id']):
                          echo "selected";
                        endif; ?>>
                      <?php echo remove_junk($cat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-control" name="product-photo">
                  <option value=""> No image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int) $photo['id']; ?>" <?php if ($product[0]['media_id'] === $photo['id']):
                          echo "selected";
                        endif; ?>>
                      <?php echo $photo['file_name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="number" class="form-control" name="over_stock"
                    placeholder="estimated over stock limit..."
                    value="<?php echo remove_junk($product[0]['over_stock']); ?>" required>
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
                  <input type="number" class="form-control" min="0" name="product-quantity"
                    value="<?php echo remove_junk($product[0]['quantity']); ?>" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </span>
                  <select class="form-control" name="unit" id="unit" required>
                    <option value="<?php echo remove_junk($product[0]['unit']); ?> ">
                      <?php echo
                        remove_junk($product[0]['unit']); ?>
                    </option>

                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="numbers" min="0" class="form-control" name="buying-price"
                    value="<?php echo remove_junk($product[0]['buy_price']); ?>" required>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="product" class="btn btn-danger">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
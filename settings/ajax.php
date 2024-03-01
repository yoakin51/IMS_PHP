<?php
require_once('../includes/load.php');
if (!$session->isUserLoggedIn(true)) {
  redirect('../index.php', false);
}
?>

<?php
// Auto suggetion
$html = '';
if (isset($_POST['product_name']) && strlen($_POST['product_name'])) {
  $products = find_product_by_title($_POST['product_name']);
  if ($products) {
    foreach ($products as $product):
      $html .= "<li class=\"list-group-item\">";
      $html .= $product['prod_name'];
      $html .= "</li>";
    endforeach;
  } else {
    $html .= '<li onClick=\"fill(\'' . addslashes() . '\')\" class=\"list-group-item\">';
    $html .= 'Not found';
    $html .= "</li>";
  }
  echo json_encode($html);
}
?>
<?php
// find all product
if (isset($_POST['p_name']) && strlen($_POST['p_name'])) {
  $product_title = remove_junk($db->escape($_POST['p_name']));
  if ($results = find_all_product_info_by_title($product_title)) {
    foreach ($results as $result) {

      $html .= "<tr>";
      $html .= "<td id=\"item_name\">" . $result['prod_name'] . "</td>";
      $html .= "<td id=\"item_code\">" . $result['prod_code'] . "</td>";
      $html .= "<td id=\"item_category\">" . $result['categorie'] . "</td>";
      $html .= "<td id=\"item_price\">" . $result['buy_price'] . "</td>";
      $html .= "<td id=\"s_qty\">";
      $html .= "<input type=\"number\" class=\"form-control\" name=\"quantity\" min=\"1\">";
      $html .= "</td>";
      $html .= "<td id=\"\">" . $result['unit'] . "</td>";
      $html .= "<td>";
      $html .= "<button type=\"submit\" name=\"request\" value=\"{$result['prod_id']}\" class=\"btn btn-primary addToCartBtn\">Add</button>";
      $html .= "</td>";
      $html .= "</tr>";

    }
  } else {
    $html = '<tr><td>product name not resgister in database</td></tr>';
  }

  echo json_encode($html);
}
?>
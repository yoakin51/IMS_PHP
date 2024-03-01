<?php
require_once('../includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('../index.php', false);
}
?>

<?php
if (isset($_POST['title']) && is_array($_POST['title'])) {
    $html = ''; // Initialize an empty string to store the HTML result

    foreach ($_POST['title'] as $product_title) {
        $product_title = remove_junk($db->escape($product_title));

        if ($results = find_all_product_info_by_title($product_title)) {
            foreach ($results as $result) {
                $html .= "<div class='product-container'>";
                $html .= "<p>Product Name: " . $result['prod_name'] . "</p>";
                $html .= "<input type='hidden' name='item_id' value='{$result['prod_id']}'>";
                $html .= "<input type='hidden' name='item_name' value='{$result['prod_name']}'>";
                $html .= "<input type='hidden' name='item_code' value='{$result['prod_code']}'>";
                $html .= "<p>Quantity: <input type='text' class='form-control' name='quantity' value='1'></p>";
                $html .= "<p>Measurement: ";
                $html .= "<select class='form-control' name='measurement'>";
                $html .= "<option value='units'>units</option>";
                $html .= "<option value='Kg'>Kg</option>";
                $html .= "<option value='grams'>grams</option>";
                $html .= "<option value='dozens'>dozens</option>";
                $html .= "<option value='bale'>bale</option>";
                $html .= "</select></p>";
                $html .= "<button type='submit' name='request' class='btn btn-primary'>SUBMIT</button>";
                $html .= "</div>";
            }
        } else {
            $html .= '<div class="product-container"><p>Product name not registered in the database</p></div>';
        }
    }

    echo json_encode($html);
}

?>
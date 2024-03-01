<?php
$page_title = 'Product List';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$products = join_product_table();
$count = count_items('cart');
?>

<?php include_once('../layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
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
    <div class="col-md-12">

        <form method="post" action="request.php">
            <table class="table table-bordered">
                <tbody id="product_info"> </tbody>
            </table>
        </form>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div>
                    <h2>Items in store
                        <!-- Display cart count -->
                        <div class="pull-right">Request items:<span id="count">
                                <?php echo $count; ?>
                            </span><span id="cartCount">0
                            </span>

                        </div>
                    </h2>
                </div>


                <div id="viewBtn">
                    <a href="item_list.php">VIEW </a>
                    <a>CLEAR </a>
                </div>

            </div>
            <div class=" panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>

                            <th> Product Title </th>
                            <th class="text-center" style="width: 10%;"> Product Code </th>
                            <th class="text-center" style="width: 10%;"> Category </th>
                            <th class="text-center" style="width: 10%;"> Price </th>
                            <th class="text-center" style="width: 5%;"> Quantity </th>
                            <th class="text-center" style="width: 6%;"> Unit</th>
                            <th class="text-center" style="width: 100px;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo count_id(); ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($product['prod_name']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($product['prod_code']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($product['categorie']); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($product['buy_price']); ?>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="size" name="quantity" size="2" value="1" min="1">
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($product['unit']); ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="submit" value="<?php echo $product['prod_id']; ?>"
                                            class="addToCartBtn">Add</button>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <!-- </form>-->
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        const viewBtn = document.getElementById("viewBtn");
        viewBtn.style.display = 'none';
        const ajaxCount = document.getElementById("cartCount");
        ajaxCount.style.display = 'none';
        const staticCount = document.getElementById("count");
        staticCount.style.display = 'block';
        $(document).on('click', '.addToCartBtn', function (e) {
            e.preventDefault();
            var id = $(this).val();
            var quantity = $(".size").val();
            var data = {
                'id': id,
                'quantity': quantity
            }
            console.log(data);
            $.ajax({
                type: "POST",
                url: "addToCart.php",
                data: data,
                // dataType: 'json',
                success: function (response) {

                    var cartCount = JSON.parse(response).cartCount;
                    $("#cartCount").text(cartCount);

                    if (cartCount > 0) {
                        viewBtn.style.display = 'block';
                        ajaxCount.style.display = 'block';
                        staticCount.style.display = 'none';
                    } else {
                        viewBtn.style.display = 'none';
                        ajaxCount.style.display = 'none';
                        staticCount.style.display = 'block';
                    }
                }
            });
        });
    });
</script>



<?php include_once('../layouts/footer.php'); ?>
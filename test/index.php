<?php
$page_title = 'Store Requisition';
require_once('../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3); //if user_level is greater than or equal return true
?>

<?php include_once('../layouts/header.php'); ?>
<div class="row">
    <div class="alert alert-info alert-with-icon" data-notify="container">
        <button type="button" aria-hidden="true" class="close">
            <i class="nc-icon nc-simple-remove"></i>
        </button>
        <span data-notify="icon" class="nc-icon nc-bell-55"></span>
        <span data-notify="message">
            <h6>TEXT HERE</h6>
        </span>
    </div>

</div>
<div id="alerts">
</div>
<script>
    $(document).ready(function () {
        function charger() {

            setTimeout(function () {
                $.ajax({
                    url: "lowstock.php",
                    type: "GET",
                    success: function (response) {
                        console.log(response);
                        var alerts = JSON.parser(response);
                        $('#alerts').empty();

                        alerts.forEach(function (alert) {
                            var itemHtml = '<div class="alert">';
                            itemHtml += '<h4>' + alert.product_name + '</h4>';
                            itemHtml += '<p>Quantity: ' + alert.quantity + '</p>';
                            itemHtml += '</div>';
                            $('#alerts').append(itemHtml);
                        });

                    }
                });

                charger();

            }, 5000);
        }

        charger();
    });
</script>


function displaySelectedItems() {
$("#selected_items_body").empty();
selectedItems.forEach(function (itemId) {
var selectedItem = itemsArray.find(function (item) {
return item.prod_id === itemId;
});
if (selectedItem) {
$("#selected_items_body").append(
"<tr>" +
    "<td>" + selectedItem.prod_id + "</td>" +
    "<td>" + selectedItem.prod_code + "</td>" +
    "<td>" + selectedItem.low_stock + "</td>" +
    "<td>" + selectedItem.buy_price + "</td>" +
    "<td><input type='number' class='quantity_input' data-id='" + selectedItem.prod_id + "'
            placeholder='Enter Quantity'></td>" +
    "</tr>"
);
} else {
console.error("Item with ID " + itemId + " not found.");
}
});
}


$("#insert_button").click(function () {
var quantities = [];
$(".quantity_input").each(function () {
var itemId = $(this).data('id');
var quantity = $(this).val();
quantities.push({ id: itemId, qty: quantity });
});
var selectedSupplier = $('#supplier_id').val();
if (selectedSupplier !== null) {
v
$.ajax({
url: "insert_po.php",
type: "POST",
data: { items: quantities, supplier: selectedSupplier },
success: function (response) {
console.log("Items inserted successfully");
selectedItems = [];
$("#selected_items_body").empty();
}
});
} else {
alert("Please select a supplier.");
}
});

setInterval(retrieveItems, 5000);

<?php include_once('../layouts/footer.php'); ?>
<?php
require_once('../includes/load.php');

// Get the button value from the AJAX request
$buttonValue = isset($_GET['buttonValue']) ? $_GET['buttonValue'] : '';

$requests = get_request_by_id($buttonValue);
?>

<?php foreach ($requests as $request): ?>
    <span class="close" onclick="closeModal(3)">&times;</span>
    <div class="container">
        <div class="title">
            <h4>ADAMA DEVELOPMENT P.L.C</h4>
            <H4>ADAMA SPINNING FACTORY</H4>
            <H3>STORE REQUISITION</H3>
        </div>


        <table>
            <tr>
                <th>Item</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Date:</td>
                <td>
                    <?php echo $request['timestamp']; ?>
                </td>
            </tr>
            <tr>
                <td>Requested by:</td>
                <td>
                    <?php echo $request['name']; ?>
                </td>
            </tr>
            <tr>
                <td>Department:</td>
                <td>
                    <?php echo $request['department']; ?>
                </td>
            </tr>
            <tr>
                <td>Item code:</td>
                <td>
                    <?php echo $request['prod_code']; ?>
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <?php echo $request['prod_name']; ?>
                </td>
            </tr>
            <tr>
                <td>Quantity:</td>
                <td>
                    <?php echo $request['qty'] . " " . $request['measurement']; ?>
                </td>
            </tr>
            <tr>
                <td>Unit price(ETB):</td>
                <td>
                    <?php echo $request['buy_price']; ?>
                </td>
            </tr>
            <tr>
                <td>Total Price(ETB):</td>
                <td>
                    <?php $price = $request['buy_price'];
                    $qty = $request['qty'];
                    $total = $price * $qty;
                    echo $total;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Approved by:</td>
                <td>
                    <?php
                    $manager = $request['approved_by'];
                    $man = find_user_info($manager);
                    echo $man;
                    ?>
                </td>
            </tr>

        </table>
        <a href="../request/view_requisitions.php?request_id=<?php echo $buttonValue; ?>I">Issue</a>
        <a href="../request/view_requisitions.php?request_id=<?php echo $buttonValue; ?>D">Decline</a>
    </div>
<?php endforeach; ?>
<?php
require_once('../includes/load.php');

// Get the button value from the AJAX request
$buttonValue = isset($_GET['buttonValue']) ? $_GET['buttonValue'] : '';

$requests = get_request_by_id($buttonValue);
?>

<?php foreach ($requests as $request): ?>
    <span class="close" onclick="closeModal(5)">&times;</span>
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
                    if ($request['approved_by'] != 'Null' || $request['approved_by'] != 'Declined') {
                        $manager = $request['approved_by'];
                        $man = find_user_info($manager);
                        echo $man;
                    } ?>
                </td>
            </tr>

            <tr>
                <td>Issued by:</td>
                <td>
                    <?php
                    if ($request['issued_by'] !== null || $request['issued_by'] !== 'Declined') {
                        $storeman = $request['issued_by'];
                        $store = find_user_info($storeman);
                        echo $store;
                    } ?>
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <?php
                    if ($request['issued_by'] !== null && $request['issued_by'] !== 'Declined' && $request['confirmed'] === null) {
                        echo '<strong class="warning">CONFIRM</strong>';

                    } elseif ($request['approved_by'] === 'Declined' && $request['confirmed'] === null) {
                        echo '<strong class="danger">DENIED by manager</strong>';
                    } else if ($request['issued_by'] === 'Declined' && $request['confirmed'] === null) {
                        echo '<strong class="danger">DENIED by store</strong>';
                    } elseif ($request['issued_by'] === null && $request['confirmed'] === null) {
                        echo '<strong class="warning">PENDING...</strong>';
                    } elseif ($request['confirmed'] !== NULL) {
                        echo '<strong class="success">CONFIRMED</strong>';
                    }
                    ?>
                </td>
            </tr>

        </table>
        <?php
        if ($request['issued_by'] !== null && $request['issued_by'] !== 'Declined' && $request['confirmed'] === null) { ?>
            <p>Confirm to recieving the materials </p>

            <a href="../request/requester_history.php?request_id=<?php echo $buttonValue; ?>">Confirm</a>
        <?php } elseif ($request['confirmed'] !== NULL) { ?>
            <button onclick="printModal(5)">Print</button>
        <?php } ?>
    </div>
<?php endforeach; ?>
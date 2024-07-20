<?php
include 'config.php';
include 'navbar.html';

function getorders($phone_number) {
    // Fetch orders
    $url = SUPABASE_URL . "/rest/v1/orders?phonenumber=eq.$phone_number";
    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'GET',
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        die('Error retrieving data');
    }
    $orders = json_decode($result, true);

    if (empty($orders)) {
        echo "No orders found.";
    } else {
        // Reverse the orders array
        $orders = array_reverse($orders);

        echo "<h1>List of orders</h1><table class='table table-striped'>";
        echo "<tr><th>ID</th><th>Full Name</th><th>Phone Number</th><th>Email</th><th>Address</th><th>Menu Name</th><th>QTY</th><th>Amount</th><th>Order Status</th><th>Rider</th></tr>";

        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order['id'] . "</td>";
            echo "<td>" . $order['fullname'] . "</td>";
            echo "<td>" . $order['phonenumber'] . "</td>";
            echo "<td>" . $order['email'] . "</td>";
            echo "<td>" . $order['address'] . "</td>";
            echo "<td>" . implode(', ', $order['menu_name']) . "</td>";
            echo "<td>" . implode(', ', $order['qty']) . "</td>";
            echo "<td>" . $order['amt'] . "</td>";
            echo "<td>" . $order['Status'] . "</td>";
            echo "<td>" . $order['Rider'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

if (isset($_GET['phonenumber'])) {
    $phone_number = $_GET['phonenumber'];
    echo '<div class="get-orders">';
    getorders($phone_number);
    echo '</div>';
} else {
    echo '<script type="text/javascript">';
    echo 'let phone_number = prompt("Please enter your phone number:");';
    echo 'if (phone_number != null && phone_number != "") {';
    echo '    window.location.href = "?phonenumber=" + phone_number;';
    echo '}';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" type="text/css" href="order.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="container">
</body>
</html>

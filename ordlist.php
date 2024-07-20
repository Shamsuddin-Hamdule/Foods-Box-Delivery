<?php

function getorders() {
    // Fetch orders
    $url = SUPABASE_URL . "/rest/v1/orders";
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

    // Fetch riders
    $url_riders = SUPABASE_URL . "/rest/v1/drivers";
    $result_riders = file_get_contents($url_riders, false, $context);
    if ($result_riders === FALSE) {
        die('Error retrieving riders data');
    }
    $riders = json_decode($result_riders, true);

    if (empty($orders)) {
        echo "No orders found.";
    } else {
        // Reverse the orders array
        $orders = array_reverse($orders);

        echo "<h1>List of orders</h1><table>";
        echo "<tr><th>ID</th><th>Date</th><th>Full Name</th><th>Phone Number</th><th>Email</th><th>Address</th><th>Menu Name</th><th>QTY</th><th>Amount</th><th>Order Status</th><th>Rider</th><th>Edit</th><th>Delete</th></tr>";

        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order['id'] . "</td>";
            echo "<td>" . $order['DateOfCreation'] . "</td>";
            echo "<td>" . $order['fullname'] . "</td>";
            echo "<td>" . $order['phonenumber'] . "</td>";
            echo "<td>" . $order['email'] . "</td>";
            echo "<td>" . $order['address'] . "</td>";
            echo "<td>" . implode(', ', $order['menu_name']) . "</td>";
            echo "<td>" . implode(', ', $order['qty']) . "</td>";
            echo "<td>" . $order['amt'] . "</td>";
            echo "<td>" . $order['Status'] . "</td>";
            echo "<td>" . $order['Rider'] . "</td>";

            echo "<td><a href='editO.php?id=" . $order['id'] . "'>Edit</a></td>";
            echo "<td><a href='deleteO.php?id=" . $order['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

echo '<div class="get-orders">';
getorders();
echo '</div>';
?>

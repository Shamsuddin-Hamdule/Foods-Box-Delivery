<?php
include 'navbarA.html';
// Include configuration file for Supabase URL and API Key
include('config.php');

// Fetch order details
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $url = SUPABASE_URL . "/rest/v1/orders?id=eq." . $order_id;
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
    $order = json_decode($result, true);

    if (empty($order)) {
        die('Order not found.');
    }
    $order = $order[0]; // Get the first item in the array
} else {
    die('Order ID not provided.');
}

// Fetch riders
$url_riders = SUPABASE_URL . "/rest/v1/drivers";
$result_riders = file_get_contents($url_riders, false, $context);
if ($result_riders === FALSE) {
    die('Error retrieving riders data');
}
$riders = json_decode($result_riders, true);

// Update order details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $rider = $_POST['rider'];

    $data = [
        'Status' => $status,
        'Rider' => $rider
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n" .
                        "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'PATCH',
            'content' => json_encode($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        die('Error updating data');
    }
    header("Location: order.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Edit Order</h1>
    <form method="POST">
        <label for="status">Status:</label><br>
        <select id="status" name="status">
            <option value="Order received" <?php if ($order['Status'] == 'Order received') echo 'selected'; ?>>Order received</option>
            <option value="Order processed" <?php if ($order['Status'] == 'Order processed') echo 'selected'; ?>>Order processed</option>
            <option value="Order completed" <?php if ($order['Status'] == 'Order completed') echo 'selected'; ?>>Order completed</option>
        </select><br>

        <label for="rider">Rider:</label><br>
        <select id="rider" name="rider">
            <option value="Rider not assigned yet" <?php if ($order['Rider'] == 'Rider not assigned yet') echo 'selected'; ?>>Rider not assigned yet</option>
            <?php
            foreach ($riders as $rider) {
                echo '<option value="' . $rider['name'] . '"' . ($order['Rider'] == $rider['name'] ? ' selected' : '') . '>' . $rider['name'] . '</option>';
            }
            ?>
        </select><br>

        <input type="submit" value="Update Order">
    </form>
</body>
</html>

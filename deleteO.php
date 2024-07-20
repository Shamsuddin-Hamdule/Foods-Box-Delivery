<?php
include 'config.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $url = SUPABASE_URL . "/rest/v1/orders?id=eq." . $order_id;

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error deleting order');
    }

    echo "<script>alert('order deleted successfully');</script>";
    header("Location: order.php");
    exit;
} else {
    die('Invalid request');
}
?>

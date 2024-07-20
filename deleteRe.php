<?php
include 'config.php';

if (isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];

    $url = SUPABASE_URL . "/rest/v1/restaurants?id=eq." . $restaurant_id;

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error deleting restaurant');
    }

    echo "<script>alert('Restaurant deleted successfully');</script>";
    header("Location: Restaurant.php");
    exit;
} else {
    die('Invalid request');
}
?>

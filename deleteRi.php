<?php
include 'config.php';

if (isset($_GET['id'])) {
    $driver_id = $_GET['id'];

    $url = SUPABASE_URL . "/rest/v1/drivers?id=eq." . $driver_id;

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error deleting driver');
    }

    echo "<script>alert('driver deleted successfully');</script>";
    header("Location: Rider.php");
    exit;
} else {
    die('Invalid request');
}
?>

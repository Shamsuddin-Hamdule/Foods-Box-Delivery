<?php
include 'config.php';

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];

    $url = SUPABASE_URL . "/rest/v1/menu?id=eq." . $menu_id;

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error deleting menu');
    }

    echo "<script>alert('menu deleted successfully');</script>";
    header("Location: MenuA.php");
    exit;
} else {
    die('Invalid request');
}
?>

<?php
include 'navbarA.html';
require 'config.php'; // Add your Supabase credentials in this file

if (isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];
    $url = SUPABASE_URL . "/rest/v1/restaurants?id=eq." . $restaurant_id;

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

    $restaurant = json_decode($result, true)[0];
} else {
    die('No restaurant ID provided');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $timing = $_POST['timing'];
    $address = $_POST['address'];
    $cuisine_type = $_POST['cuisine_type'];

    $data = json_encode([
        'name' => $name,
        'rating' => $rating,
        'timing' => $timing,
        'address' => $address,
        'cuisine_type' => explode(', ', $cuisine_type)
    ]);

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n" .
                        "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'PATCH',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error updating data');
    }

    header('Location: Restaurant.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Edit Restaurant</h1>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $restaurant['name']; ?>" required><br>

        <label for="rating">Rating:</label>
        <input type="text" id="rating" name="rating" value="<?php echo $restaurant['rating']; ?>" required><br>

        <label for="timing">Timing:</label>
        <input type="text" id="timing" name="timing" value="<?php echo $restaurant['timing']; ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $restaurant['address']; ?>" required><br>

        <label for="cuisine_type">Cuisine Type (comma separated):</label>
        <input type="text" id="cuisine_type" name="cuisine_type" value="<?php echo implode(', ', $restaurant['cuisine_type']); ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>

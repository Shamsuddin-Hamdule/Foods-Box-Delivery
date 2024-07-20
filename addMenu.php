<?php
include 'config.php';

$url = SUPABASE_URL . "/rest/v1/restaurants";
$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n" .
                    "apikey: " . SUPABASE_API_KEY . "\r\n",
        'method' => 'GET',
    ],
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$restaurants = json_decode($result, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $restaurant_name = $_POST['restaurant_name'];
    $price = $_POST['price'];
    $veg_nonveg = $_POST['veg_nonveg'];
    $cuisine_type = $_POST['cuisine_type'];

    if (empty($name) || empty($restaurant_name) || empty($cuisine_type)) {
        die('Please fill all required fields.');
    }

    // Handle file upload
    if (isset($_FILES['menu_photo']) && $_FILES['menu_photo']['error'] == 0) {
        $photo = $_FILES['menu_photo'];
        $photo_path = 'uploads/' . basename($photo['name']);
        
        // Move the uploaded file to the target directory
        if (!move_uploaded_file($photo['tmp_name'], $photo_path)) {
            die('Error uploading photo');
        }
    } else {
        $photo_path = null; // No photo uploaded
    }

    $url = SUPABASE_URL . "/rest/v1/menu";
    $data = [
        'name' => $name,
        'restaurant_name' => $restaurant_name,
        'price' => $price,
        'veg_nonveg' => $veg_nonveg,
        'cuisine_type' => $cuisine_type,
        'menu_photo' => $photo_path,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n" .
                        "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error inserting data');
    }

    echo "Data inserted successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H1> Add a new Menu </H1>
<form action="" method="post" enctype="multipart/form-data">
    <label for="name"> Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="restaurant_name">Restaurant Name:</label>
    <select id="restaurant_name" name="restaurant_name" required>
        <option value="">Select a restaurant</option>
        <?php foreach ($restaurants as $restaurant) { ?>
            <option value="<?php echo $restaurant['name']; ?>"><?php echo $restaurant['name']; ?></option>
        <?php } ?>
    </select><br><br>

    <label for="price"> Prices:</label>
    <input type="text" id="price" name="price" required><br><br>

    <label for="veg_nonveg">veg/non-veg:</label>
    <select id="veg_nonveg" name="veg_nonveg" required>
        <option value="">Select a veg/non-veg</option>
        <option value="veg">veg</option>
        <option value="non-veg">non-veg</option>
        <option value="Contains egg">Contains egg</option>
    </select><br><br>

    <label for="cuisine_type">Cuisine Type:</label>
    <div>
    <input type="checkbox" id="Italian" name="cuisine_type[]" value="Italian">
    <label for="Italian">Italian</label><br>

    <input type="checkbox" id="Chinese" name="cuisine_type[]" value="Chinese">
    <label for="Chinese">Chinese</label><br>

    <input type="checkbox" id="Indian" name="cuisine_type[]" value="Indian">
    <label for="Indian">Indian</label><br>

    <input type="checkbox" id="Mexican" name="cuisine_type[]" value="Mexican">
    <label for="Mexican">Mexican</label><br>

    <input type="checkbox" id="Japanese" name="cuisine_type[]" value="Japanese">
    <label for="Japanese">Japanese</label><br>

    <input type="checkbox" id="Other" name="cuisine_type[]" value="Other">
    <label for="Other">Other</label><br>
</div>

    <label for="menu_photo">Menu Photo:</label>
    <input type="file" id="menu_photo" name="menu_photo"><br><br>

<input type="submit" value="Submit">
</form>
</body>
</html>

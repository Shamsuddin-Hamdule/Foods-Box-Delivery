<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $timing = $_POST['timing'];
    $address = $_POST['Address'];
    $rating = $_POST['ratings'];
    $cuisine_type = $_POST['cuisine_type'];

    // Check if required fields are filled
    if (empty($name) || empty($cuisine_type)) {
        die('Please fill all required fields.');
    }

    // Handle file upload
    $photo_url = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_name = basename($_FILES['photo']['name']);
        $upload_dir = 'uploads/'; // Define your upload directory
        $upload_path = $upload_dir . $photo_name;

        if (move_uploaded_file($photo_tmp_name, $upload_path)) {
            $photo_url = $upload_path; // Store the upload path as the photo URL
        } else {
            die('Error uploading photo.');
        }
    }

    // Prepare data for Supabase
    $url = SUPABASE_URL . "/rest/v1/restaurants";
    $data = [
        'name' => $name,
        'timing' => $timing,
        'address' => $address,
        'rating' => $rating,
        'cuisine_type' => $cuisine_type,
        'photo_url' => $photo_url
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
    <title>Add a new Restaurant</title>
</head>
<body>
    <h1>Add a new Restaurant</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Restaurant Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="timing">Timing:</label>
        <input type="text" id="timing" name="timing" required><br><br>
        
        <label for="ratings">Ratings:</label>
        <input type="number" id="ratings" name="ratings" required><br><br>
        
        <label for="Address">Address:</label>
        <input type="text" id="Address" name="Address" required><br><br>

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

        <label for="photo">Restaurant Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

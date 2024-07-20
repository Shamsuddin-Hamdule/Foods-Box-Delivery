<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if (empty($name) || empty($phone)) {
        die('Please fill all required fields.');
    }

    $url = SUPABASE_URL . "/rest/v1/drivers";
    $data = [
        'name' => $name,
        'phone' => $phone
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
    <H1> Add a new Rider </H1>
<form action="" method="post">
    <label for="name">Rider Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="Phone Number"> Phone number:</label>
    <input type="number" id="phone" name="phone" value="phone">
    
    <input type="submit" value="Submit">
</form>
</body>
</html>
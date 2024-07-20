<?php
include 'navbarA.html';
// Include configuration file
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $url = SUPABASE_URL . "/rest/v1/drivers?id=eq." . $id;

    $data = [
        'name' => $name,
        'phone' => $phone,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                         "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method'  => 'PATCH',
            'content' => json_encode($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error updating data');
    } else {
        header('Location: Rider.php');
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $url = SUPABASE_URL . "/rest/v1/drivers?id=eq." . $id;

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

    $drivers = json_decode($result, true);

    if (empty($drivers)) {
        die('No driver found');
    }

    $driver = $drivers[0];
} else {
    die('Invalid request');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Edit Driver</h1>
    <form method="post" action="edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($driver['id']); ?>">
        <label for="name">Driver Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($driver['name']); ?>"><br>
        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($driver['phone']); ?>"><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>

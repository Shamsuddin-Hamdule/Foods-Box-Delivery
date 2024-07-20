<?php
include 'navbarA.html';
include 'config.php';

function getMenuById($id) {
    $url = SUPABASE_URL . "/rest/v1/menu?id=eq.$id";

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

    $menus = json_decode($result, true);

    if (empty($menus)) {
        die('No menu found.');
    }

    return $menus[0];
}

function updateMenu($id, $data) {
    $url = SUPABASE_URL . "/rest/v1/menu?id=eq.$id";

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n" .
                        "Content-Type: application/json\r\n",
            'method' => 'PATCH',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error updating data');
    }

    return json_decode($result, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $menu = getMenuById($id);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $data = [
        'name' => $_POST['name'],
        'restaurant_name' => $_POST['restaurant_name'],
        'price' => $_POST['price'],
        'veg_nonveg' => $_POST['veg_nonveg'],
        'cuisine_type' => explode(', ', $_POST['cuisine_type']),
    ];
    updateMenu($id, $data);
    header('Location: Menu.php'); // Redirect to a success or listing page
    exit();
} else {
    die('Invalid request');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Edit Menu</h1>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($menu['id']); ?>">
        <label for="name">Menu Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($menu['name']); ?>" required><br>
        <label for="restaurant_name">Restaurant Name:</label>
        <input type="text" id="restaurant_name" name="restaurant_name" value="<?php echo htmlspecialchars($menu['restaurant_name']); ?>" required><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($menu['price']); ?>" required><br>
        <label for="veg_nonveg">Veg/Non-veg:</label>
        <input type="text" id="veg_nonveg" name="veg_nonveg" value="<?php echo htmlspecialchars($menu['veg_nonveg']); ?>" required><br>
        <label for="cuisine_type">Cuisine Type (comma separated):</label>
        <input type="text" id="cuisine_type" name="cuisine_type" value="<?php echo htmlspecialchars(implode(', ', $menu['cuisine_type'])); ?>" required><br>
        <button type="submit">Update Menu</button>
    </form>
</body>
</html>

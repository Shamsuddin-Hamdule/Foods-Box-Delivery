<?php

function getRestaurants() {
    $url = SUPABASE_URL . "/rest/v1/restaurants";

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

    $restaurants = json_decode($result, true);

    if (empty($restaurants)) {
        echo " No restaurants found.";
    } else {
        echo "<H1> List of Restaurants </H1><table>";
        echo "<tr><th>ID</th><th>Restaurant Name</th><th>Rating</th><th>Timing</th><th>address</th><th>Cuisine Type</th><th>Edit</th><th>Delete</th></tr>";

        foreach ($restaurants as $restaurant) {
            echo "<tr>";
            echo "<td>" . $restaurant['id'] . "</td>";
            echo "<td>" . $restaurant['name'] . "</td>";
            echo "<td>" . $restaurant['rating'] . "</td>";
            echo "<td>" . $restaurant['timing'] . "</td>";
            echo "<td>" . $restaurant['address'] . "</td>";
            echo "<td>". implode(', ', $restaurant['cuisine_type']). "</td>";
            echo "<td><a href='editRe.php?id=" . $restaurant['id'] . "'>Edit</a></td>";
            echo "<td><a href='deleteRe.php?id=" . $restaurant['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

//echo '<div class="get-restaurants">';
//getRestaurants();
echo '</div>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="get-restaurants">
        <?php getRestaurants(); ?>
    </div>
    <?php
    if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
        echo "<script>alert('Restaurant deleted successfully');</script>";
    }
    ?>
</body>
</html>
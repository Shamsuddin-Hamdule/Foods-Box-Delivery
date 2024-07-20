<?php

function getmenus() {
    $url = SUPABASE_URL . "/rest/v1/menu";

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
        echo " No menus found.";
    } else {
        echo "<H1> List of menu </H1><table>";
        echo "<tr><th>ID</th><th>menu Name</th>
        <th>Restaurant Name</th><th>Price</th><th>Veg/non-veg</th>
        <th>Cuisine Type</th>
        <th>Edit</th><th>Delete</th></tr>";

        foreach ($menus as $menu) {
            echo "<tr>";
            echo "<td>" . $menu['id'] . "</td>";
            echo "<td>" . $menu['name'] . "</td>";
            echo "<td>" . $menu['restaurant_name'] . "</td>";
            echo "<td>" . $menu['price'] . "</td>";
            echo "<td>" . $menu['veg_nonveg'] . "</td>";
            echo "<td>". implode(', ', $menu['cuisine_type']). "</td>";
            echo "<td><a href='editM.php?id=" . $menu['id'] . "'>Edit</a></td>";
            echo "<td><a href='deleteM.php?id=" . $menu['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

echo '<div class="get-menus">';
getmenus();
echo '</div>';
?>
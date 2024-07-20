<?php

function getdrivers() {
    $url = SUPABASE_URL . "/rest/v1/drivers";

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
        echo " No Drivers found.";
    } else {
        echo "<H1> List of Drivers </H1><table>";
        echo "<tr><th>ID</th><th>Driver Name</th><th> Phone no</th><th>Edit</th><th>Delete</th></tr>";

        foreach ($drivers as $driver) {
            echo "<tr>";
            echo "<td>" . $driver['id'] . "</td>";
            echo "<td>" . $driver['name'] . "</td>";
            echo "<td>". $driver['phone']. "</td>";
            echo "<td><a href='editRi.php?id=" . $driver['id'] . "'>Edit</a></td>";
            echo "<td><a href='deleteRi.php?id=" . $driver['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

echo '<div class="get-drivers">';
getdrivers();
echo '</div>';
?>
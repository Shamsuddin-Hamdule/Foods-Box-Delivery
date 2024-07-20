<?php
include 'config.php'; // Include the config file

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
        echo "No restaurants found.";
    } else {
        // Display the restaurant cards
        foreach ($restaurants as $restaurant) {
            $restaurant_id = $restaurant['id'];
            $restaurant_name = $restaurant['name'];
            $restaurant_rating = $restaurant['rating'];
            $restaurant_cuisine = $restaurant['cuisine_type'];
            $restaurant_address = $restaurant['address'];
            $restaurant_photo_url = $restaurant['photo_url'];

            echo '
                <div class="restaurant-card">
                    ';
            if (!empty($restaurant_photo_url)) {
                echo '<div class="restaurant-photo"><img src="'.$restaurant_photo_url.'" alt="'.$restaurant_name.'" height = 100px width = 100px ></div>';
            }
            echo '
                    <div class="restaurant-content">
                        <h3 class="restaurant-name">'.$restaurant_name.'</h3>
                        <div class="restaurant-rating">'.str_repeat('⭐', $restaurant_rating).'('.number_format($restaurant_rating, 1).')</div>
                        <div class="restaurant-cuisine">'.implode(', ', $restaurant_cuisine).'</div>
                        <div class="restaurant-address">'.$restaurant_address.'</div>
                        <a href="ResMenu.php?restaurant_name='.$restaurant_name.'"><button>Order Now</button></a>
                    </div>
                </div>
            ';
        }
    }
}
getRestaurants();
?>

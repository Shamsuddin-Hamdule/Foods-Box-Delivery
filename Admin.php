<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - FOODS BOX DELIVERY</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .count-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        .count-card h3 {
            margin-bottom: 10px;
        }
        .count-card p {
            font-size: 2em;
            margin: 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FOODS BOX DELIVERY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Restaurant.php">Restaurant</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="Rider.php">Rider</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="MenuA.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="order.php">Order</a>
                </li>
            </ul>
            <a href="Customer.php" class="btn btn-outline-success">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#manageRestaurants" class="list-group-item list-group-item-action">Manage Restaurants</a>
                <a href="#manageRiders" class="list-group-item list-group-item-action">Manage Riders</a>
                <a href="#manageMenu" class="list-group-item list-group-item-action">Manage Menu</a>
                <a href="#manageOrders" class="list-group-item list-group-item-action">Manage Orders</a>
            </div>
        </div>
        <div class="col-md-9">
            <div id="manageRestaurants" class="admin-section">
                <h2>Manage Restaurants</h2>
                <div class="count-card">
                    <h3>Number of Restaurants</h3>
                    <p id="restaurantCount">0</p>
                </div>
                <!-- Restaurant management content goes here -->
            </div>
            <div id="manageRiders" class="admin-section">
                <h2>Manage Riders</h2>
                <div class="count-card">
                    <h3>Number of Riders</h3>
                    <p id="riderCount">0</p>
                </div>
                <!-- Rider management content goes here -->
            </div>
            <div id="manageMenu" class="admin-section">
                <h2>Manage Menu</h2>
                <div class="count-card">
                    <h3>Number of Menu Items</h3>
                    <p id="menuCount">0</p>
                </div>
                <!-- Menu management content goes here -->
            </div>
            <div id="manageOrders" class="admin-section">
                <h2>Manage Orders</h2>
                <div class="count-card">
                    <h3>Number of Orders</h3>
                    <p id="orderCount">0</p>
                </div>
                <!-- Order management content goes here -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('.admin-section').hide();
        $('.list-group-item').click(function(e){
            e.preventDefault();
            $('.admin-section').hide();
            $($(this).attr('href')).show();
        });

        // Simulate fetching data
        function fetchCounts() {
            $('#restaurantCount').text(25); // Example count
            $('#riderCount').text(15);      // Example count
            $('#menuCount').text(50);       // Example count
            $('#orderCount').text(100);     // Example count
        }

        fetchCounts(); // Call the function to update counts
    });
</script>
</body>
</html>

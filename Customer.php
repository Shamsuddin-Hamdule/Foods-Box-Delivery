<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOODSBOXDELIVERY</title>
  <link rel="stylesheet" href="Cus.css">
</head>
<body>
  
  <header>
    
    <?php 
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php
  include 'navbar.html';
  ?>
  </header>

  <?php /*

  <section class="features">
    <h2>Features</h2>
    <div>
      <h3>Wide Variety of Cuisines</h3>
      <p>Explore a wide range of cuisines from various restaurants.</p>
    </div>
    <div>
      <h3>Fast Delivery</h3>
      <p>Get your food delivered to you in no time.</p>
    </div>
    <div>
      <h3>Easy Payments</h3>
      <p>Multiple payment options for your convenience.</p>
    </div>
  </section>

  <section class="how-it-works">
    <h2>How It Works</h2>
    <div>
      <h3>Search</h3>
      <p>Find restaurants and dishes near you.</p>
    </div>
    <div>
      <h3>Choose</h3>
      <p>Select your favorite dishes.</p>
    </div>
    <div>
      <h3>Enjoy</h3>
      <p>Receive and enjoy your meal.</p>
    </div>
  </section>

  */?>

  <section class="popular">
    <h2> Restaurants</h2>
    <?php include 'ResRetrive.php'; ?>
      </section>

  <section class="testimonials">
    <h2>Customer Testimonials</h2>
    <blockquote>"Amazing service and delicious food!" - Customer A</blockquote>
    <blockquote>"Quick delivery and easy to use." - Customer B</blockquote>
  </section>

  <section class="download-app">
    <h2>Download Our App</h2>
    <p>Get our app for the best experience.</p>
    <!-- Add app store and google play links -->
  </section>

  <footer>
      <div>
        <p>&copy; 2024 FOODSBOXDELIVERY. All rights reserved.</p>
      </div>
    </footer>
</body>
</html>

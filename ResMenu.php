<?php
session_start();
include 'navbar.html';
include 'config.php';

// ----------------Retrieval of id 

$url = SUPABASE_URL . "/rest/v1/orders";

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

$ords = json_decode($result, true);

if (empty($ords)) {
    $ordid = 47;
    echo $ordid + 1;
} else {
    foreach ($ords as $ord) {
        $ordid = $ord['id'];
    }
    echo $ordid = $ordid + 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_name = $_POST['menu_name'];
    $qty = $_POST['qty'];
    $amt = $_POST['amt']; // Un-comment this line if you include amount in form
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (empty($menu_name) || empty($qty) || empty($amt)) {
        die('Please fill all required fields.');
    }

    $url = SUPABASE_URL . "/rest/v1/orders";
    $data = [
        'menu_name' => $menu_name,
        'qty' => $qty,
        'amt' => $amt,
        'fullname' => $fullName,
        'phonenumber' => $phoneNumber,
        'email' => $email,
        'address' => $address,
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

    echo '<script>
            alert("Order confirmed Successfully");
            window.location.href = "orderHistory.php";
          </script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container">
    <div class="content">
        <?php
        // Displaying the menu for the selected restaurant
        if (isset($_GET['restaurant_name'])) {
            $restaurant_name = htmlspecialchars($_GET['restaurant_name']);

            $url = SUPABASE_URL . "/rest/v1/menu?restaurant_name=eq." . urlencode($restaurant_name);

            $options = [
                'http' => [
                    'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
                    'method' => 'GET',
                ],
            ];

            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);

            if ($result === FALSE) {
                $error = error_get_last();
                die('Error retrieving data: ' . $error['message']);
            }

            $menus = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'Error decoding JSON response: ' . json_last_error_msg();
                echo '<br>Response received: ' . htmlspecialchars($result);
                die();
            }

            if (empty($menus)) {
                echo "No menu items found for this restaurant.";
            } else {
                ?>
                <form action="" method="POST" onsubmit="return calculateTotal()">
                    <h2>Menu for <?php echo htmlspecialchars($restaurant_name); ?></h2>
                    <ul class="list-group">
                        <?php foreach ($menus as $menu) {
                            $menu_name = htmlspecialchars($menu['name']);
                            $menu_price = htmlspecialchars($menu['price']);
                            $menu_photo = htmlspecialchars($menu['menu_photo']);
                            ?>
                            <li class="list-group-item">
                                <div class="container">
                                    <h3><?php echo $menu_name; ?></h3>
                                    <input type="hidden" name="menu_name[]" value="<?php echo $menu_name; ?>">
                                    <?php if (!empty($menu_photo)) { ?>
                                        <img src="<?php echo $menu_photo; ?>" alt="<?php echo $menu_name; ?>" style="width: 100px; height: 100px;">
                                    <?php } ?>
                                    <div>RS: <input type="text" class="menu_price" value="<?php echo $menu_price; ?>" disabled readonly></div>
                                    <div>QTY: <input class="qty" name="qty[]" type="number" value="0" min="0" oninput="updateTotal()"></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <h3>Total Quantity: <span id="totalQuantity">0</span></h3>
                    <h3>Total Amount: RS <span id="totalAmount">0</span></h3>
                    <input type="hidden" name="amt" id="totalAmountInput" value="0">
                    <script>
                        function updateTotal() {
                            const qtys = document.querySelectorAll('.qty');
                            const prices = document.querySelectorAll('.menu_price');
                            let totalQty = 0;
                            let totalAmt = 0;

                            qtys.forEach((qty, index) => {
                                const qtyValue = parseInt(qty.value) || 0;
                                const priceValue = parseFloat(prices[index].value) || 0;
                                totalQty += qtyValue;
                                totalAmt += qtyValue * priceValue;
                            });
                            document.getElementById('totalQuantity').innerText = totalQty;
                            document.getElementById('totalAmount').innerText = totalAmt.toFixed(2);
                            document.getElementById('totalAmountInput').value = totalAmt.toFixed(2);
                        }

                        function calculateTotal() {
                            updateTotal();
                            return true; // Allow form submission
                        }
                    </script>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
                <?php
            }
        } else {
            echo "No restaurant name provided.";
        }
        ?>
    </div>
</body>
</html>

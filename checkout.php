<?php
session_start();
require("connection.php");

$clientId = $_SESSION['Clientid'];
$clientname = $_SESSION['Name'];




//tracking nubmer generator:

function generateTrackingNumber($length = 10) {
    // Define the characters used in the tracking number
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $trackingNumber = '';

    // Generate a random tracking number
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charactersLength - 1);
        $trackingNumber .= $characters[$randomIndex];
    }

    return $trackingNumber;
}

$trackingNumber = generateTrackingNumber();


try {
    // Fetch items in the client's cart
    $query = '
    SELECT p.ProductId, p.Name, p.Description, p.Photo, p.Price
    FROM product p
    INNER JOIN wishlist_product wp ON p.ProductId = wp.ProductId
    INNER JOIN wishlist w ON wp.WishlistId = w.WishlistId
    WHERE w.ClientId = :clientId
    ';
    $stmt = $con->prepare($query);
    $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the total price
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['Price'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shippingAddress = $_POST['shipping_address'];
    $shippingCost = 0; // For simplicity, assuming no shipping cost
    $orderStatus = 'Pending';

    try {
        // Insert shipping information
        $query = 'INSERT INTO shippinginfo (Address,TrackingNb, ShippingCost) VALUES (:address,:TrackingNb,:shippingCost)';
        $stmt = $con->prepare($query);
        $stmt->bindParam(':address', $shippingAddress, PDO::PARAM_STR);
        $stmt->bindParam(':shippingCost', $shippingCost, PDO::PARAM_STR);
        $stmt->bindParam(':TrackingNb', $trackingNumber, PDO::PARAM_STR);
        $stmt->execute();
        $shippingInfoId = $con->lastInsertId();

        // Create a new order
        $query = 'INSERT INTO orders (OrderDate, ClientId, ClientName, Status, ShippingInfoId) VALUES (NOW(), :clientId, :clientName, :status, :shippingInfoId)';
        $stmt = $con->prepare($query);
        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->bindParam(':clientName', $clientname, PDO::PARAM_STR);
        $stmt->bindParam(':status', $orderStatus, PDO::PARAM_STR);
        $stmt->bindParam(':shippingInfoId', $shippingInfoId, PDO::PARAM_INT);
        $stmt->execute();
        $orderId = $con->lastInsertId();

        // Add items to the order
        foreach ($cartItems as $item) {
            $query = 'INSERT INTO order_items (OrderId, ProductId, Price) VALUES (:orderId, :productId, :price)';
            $stmt = $con->prepare($query);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $item['ProductId'], PDO::PARAM_INT);
            $stmt->bindParam(':price', $item['Price'], PDO::PARAM_STR);
            $stmt->execute();
        }

        // Clear the wishlist after successful checkout
        $query = 'DELETE FROM wishlist_product WHERE WishlistId IN (SELECT WishlistId FROM wishlist WHERE ClientId = :clientId)';
        $stmt = $con->prepare($query);
        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to a confirmation page
        header('Location: confirmation.php');
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand mx-auto" href="front.php">
            <img src="images/logo1.png" alt="Company Logo" class="d-inline-block align-middle logo">
        </a>
    </div>
</nav>

<!-- Checkout Form -->
<div class="container my-5">
    <h2 class="text-center mb-4">Checkout</h2>
    <form method="POST" action="">
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <h4 class="mb-4">Order Summary</h4>
                <?php foreach ($cartItems as $item): ?>
                <div class="row mb-2">
                    <div class="col-md-8">
                        <h5><?php echo htmlspecialchars($item['Name']); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($item['Description']); ?></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p>Price: DH<?php echo number_format($item['Price'], 2); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <hr>
                <h4 class="text-end">Total: DH<?php echo number_format($totalPrice, 2); ?></h4>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <h4 class="mb-4">Shipping Information</h4>
                <div class="form-group">
                    <label for="shipping_address">Address</label>
                    <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3" required></textarea>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2 text-end">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>

<?php
session_start();
require("connection.php");

$clientId = $_SESSION['Clientid'];

try {
    // Get the latest order placed by the client
    $query = '
    SELECT o.OrderId, o.OrderDate, o.Status, SUM(oi.Price) AS TotalPrice
    FROM orders o
    INNER JOIN order_items oi ON o.OrderId = oi.OrderId
    WHERE o.ClientId = :clientId
    GROUP BY o.OrderId
    ORDER BY o.OrderDate DESC
    LIMIT 1
    ';
    $stmt = $con->prepare($query);
    $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception("No order found.");
    }

    $orderId = $order['OrderId'];
    $orderDate = $order['OrderDate'];
    $orderStatus = $order['Status'];
    $totalPrice = number_format($order['TotalPrice'], 2);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<!-- Confirmation Page -->
<div class="container my-5">
    <h2 class="text-center mb-4">Order Confirmation</h2>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Thank you for your purchase!</h4>
        <p>Your order has been successfully placed.</p>
        <hr>
        <p class="mb-0">Order ID: <?php echo htmlspecialchars($orderId); ?></p>
        <p>Date: <?php echo htmlspecialchars($orderDate); ?></p>
        <p>Status: <?php echo htmlspecialchars($orderStatus); ?></p>
        <p>Total Price: DH<?php echo $totalPrice; ?></p>
    </div>
    <div class="text-center mt-4">
        <a href="front.php" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>

</body>
</html>

<?php
session_start();
require("connection.php");

try {
    // Fetch all orders with their details and associated products
    $query = '
        SELECT o.OrderId, o.ClientName, o.OrderDate, o.Status, o.ShippingInfoId, SUM(oi.Price) AS TotalPrice
        FROM orders o
        INNER JOIN order_items oi ON o.OrderId = oi.OrderId
        GROUP BY o.OrderId
    ';
    $stmt = $con->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch order items for each order
    $orderDetails = [];
    foreach ($orders as $order) {
        $orderId = $order['OrderId'];
        $query = '
            SELECT p.Photo, p.Name, p.Price
            FROM order_items oi
            INNER JOIN product p ON oi.ProductId = p.ProductId
            WHERE oi.OrderId = :orderId
        ';
        $stmt = $con->prepare($query);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderDetails[$orderId] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/orderslist.css">
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

<!-- Orders List -->
<div class="container my-5">
    <h2 class="text-center mb-4">Orders List</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Client Name</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total Price</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['OrderId']); ?></td>
                <td><?php echo htmlspecialchars($order['ClientName']); ?></td>
                <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                <td><?php echo htmlspecialchars($order['Status']); ?></td>
                <td>DH<?php echo number_format($order['TotalPrice'], 2); ?></td>
                <td>
                    <ul class="list-unstyled">
                        <?php foreach ($orderDetails[$order['OrderId']] as $product): ?>
                        <li>
                            <img src="images/<?php echo htmlspecialchars($product['Photo']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>" class="img-thumbnail" style="width: 100px;">
                            <strong><?php echo htmlspecialchars($product['Name']); ?></strong> - DH<?php echo number_format($product['Price'], 2); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
session_start();
require("connection.php");
$clientId = $_SESSION['Clientid']; // Ensure this matches with the session variable set for ClientId

$id = $_GET["id"];
try {
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
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cart.css">
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

<!-- Shopping Cart -->
<div class="container my-5">
    <h2 class="text-center mb-4">Your Shopping Cart</h2>
    <div class="cart-items">
    <?php
        foreach($res as $index) {
            $productName = htmlspecialchars($index['Name']);
            $productDescription = htmlspecialchars($index['Description']);
            $productPrice = number_format($index['Price'], 2);
            $productImage = htmlspecialchars($index['Photo']);
    ?>
    <div class="row cart-item" data-price="<?php echo $productPrice; ?>">
        <div class="col-12 col-md-2 text-center">
            <img src="images/<?php echo $productImage; ?>" class="img-fluid" alt="<?php echo $productName; ?>">
        </div>
        <div class="col-12 col-md-4 text-center text-md-start">
            <h5><?php echo $productName; ?></h5>
            <p class="text-muted"><?php echo $productDescription; ?></p>
        </div>
        <div class="col-6 col-md-2 text-center">
            <input type="number" class="form-control text-center quantity-input" value="1" min="1">
        </div>
        <div class="col-6 col-md-2 text-center">
            <h5 class="item-total-price">DH<?php echo $productPrice; ?></h5>
        </div>
        <div class="col-12 col-md-2 text-center">
            <button class="btn btn-danger remove-item-btn">Remove</button>
        </div>
    </div>
    <hr>
    <?php
        }
    ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="front.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
        <div class="col-md-6 text-end">
            <h4>Total: <span id="cart-total">0DH</span></h4>
            <a href="checkout.php"><button class="btn btn-primary">Proceed to Checkout</button></a>
        </div>
    </div>
</div>

</div>
<footer class="bg-dark text-white">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <i class="bi bi-truck fs-2"></i>
                <h5>Fast Shipping</h5>
                <p>Get your orders delivered quickly and safely.</p>
            </div>
            <div class="col-md-4 text-center mb-3">
                <i class="bi bi-shield-check fs-2"></i>
                <h5>Secure Payments</h5>
                <p>Your payments are safe and secure with us.</p>
            </div>
            <div class="col-md-4 text-center mb-3">
                <i class="bi bi-headset fs-2"></i>
                <h5>24/7 Support</h5>
                <p>Our support team is here to assist you anytime.</p>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </div>
    </div>
</footer>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const cartItems = document.querySelectorAll('.cart-item');
        const cartTotalElement = document.getElementById('cart-total');

        function updateTotal() {
            let total = 0;
            cartItems.forEach(item => {
                const price = parseFloat(item.getAttribute('data-price'));
                const quantity = item.querySelector('.quantity-input').value;
                const itemTotalPrice = price * quantity;
                item.querySelector('.item-total-price').textContent = `${itemTotalPrice.toFixed(2)} DH`;
                total += itemTotalPrice;
            });
            cartTotalElement.textContent = `${total.toFixed(2)} DH`;
        }

        cartItems.forEach(item => {
            const quantityInput = item.querySelector('.quantity-input');
            const removeBtn = item.querySelector('.remove-item-btn');

            // Update total when quantity changes
            quantityInput.addEventListener('input', () => {
                updateTotal();
            });

            // Remove item from cart
            removeBtn.addEventListener('click', () => {
                item.remove();
                updateTotal();
            });
        });

        // Initial total calculation
        updateTotal();
        });
    </script>
</body>
</html>

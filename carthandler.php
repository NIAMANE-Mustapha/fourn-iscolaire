
<?php
//hadchi rah 
session_start();
$clientId = $_SESSION['Clientid'];
require("connection.php");
$productId = $_GET["id"];

try {
    // Step 1: Check if the client already has a wishlist
    $query = 'SELECT WishlistId FROM wishlist WHERE ClientId = :clientId';
    $stmt = $con->prepare($query);
    $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $wishlist = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($wishlist) {
        // If the wishlist exists, use its ID
        $wishlistId = $wishlist['WishlistId'];
    } else {
        // If no wishlist exists for this client, create a new one
        $query = 'INSERT INTO wishlist (ClientId) VALUES (:clientId)';
        $stmt = $con->prepare($query);
        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Get the last inserted ID
        $wishlistId = $con->lastInsertId();
    }

    // Step 2: Add the product to the wishlist
    // Prevent adding duplicate entries
    $query = 'INSERT IGNORE INTO wishlist_product (WishlistId, ProductId) VALUES (:wishlistId, :productId)';
    $stmt = $con->prepare($query);
    $stmt->bindParam(':wishlistId', $wishlistId, PDO::PARAM_INT);
    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the front page
    header('Location: front.php');
    exit();  // Ensure no further code is executed after redirect

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

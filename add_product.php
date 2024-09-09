<?php
require('connection.php');

if(isset($_POST['Ajouter_P'])){
    $Name = $_POST['Name'];
    $stock = $_POST['Stock'];
    $Description = $_POST['Description'];
    $photo = $_POST['photo'];
    $Price = $_POST['Price'];
    $CategoryId = $_POST['CategoryId'];

    try{
        $req = "INSERT INTO product (Name, Stock, Price, photo, CategoryId, Description) VALUES (:Name, :stock, :Price, :photo, :CategoryId, :Description)";
        $stat = $con->prepare($req);
        $stat->bindParam(':Name', $Name);
        $stat->bindParam(':stock', $stock);
        $stat->bindParam(':Description', $Description);
        $stat->bindParam(':photo', $photo);
        $stat->bindParam(':Price', $Price);
        $stat->bindParam(':CategoryId', $CategoryId);
        $stat->execute();
        header("location: seller_interface.php");
        exit();
    } catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/add_product.css">

</head>
<body>
    <nav>
        <a href="seller_interface.php">Back</a>
        <a href="front.php">Front</a>
    </nav>
    <main>
        <form action="add_product.php" method="POST">
            <label for="Name">Name:</label>
            <input type="text" id="Name" name="Name" required><br>
            <label for="Stock">Stock:</label>
            <input type="number" id="Stock" name="Stock"  required><br>
            <label for="Description">Description:</label>
            <textarea id="Description" name="Description" required></textarea><br>
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" required><br>
            <label for="Price">Price:</label>
            <input type="number" id="Price" name="Price" step="0.5" required><br>
            <label for="CategoryId">Category:</label>
            <select id="CategoryId" name="CategoryId" required>
                <option value="">Select category</option>
                <?php
                $req = "SELECT CategorieId, CategorieName FROM categorie";
                $res = $con->query($req);
                while($row = $res->fetch()){
                    echo '<option value="'.$row['CategorieId'].'">'.$row['CategorieName'].'</option>';
                }
                ?>
            </select>
            <input type="submit" value="Ajouter" name="Ajouter_P">
        </form>
    </main>
</body>
</html>

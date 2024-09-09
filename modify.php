<?php
require('connection.php');
$ProductId =$_GET['id'];
if(isset($_POST['modify'])){
    $Name = $_POST['Name'];
    $stock = $_POST['Stock'];
    $Description = $_POST['Description'];
    $photo = $_POST['photo'];
    $Price = $_POST['Price'];
    $CategoryId = $_POST['CategoryId'];
    

 try{
    $req = "UPDATE product SET Name = :Name, Stock = :stock, Price = :Price, photo = :photo, CategoryId = :CategoryId, Description = :Description WHERE ProductId = :ProductId";
    $stat = $con->prepare($req);
    $stat->bindParam(':Name', $Name);
    $stat->bindParam(':stock', $stock);
    $stat->bindParam(':Description', $Description);
    $stat->bindParam(':photo', $photo);
    $stat->bindParam(':Price', $Price);
    $stat->bindParam(':CategoryId', $CategoryId);
    $stat->bindParam(':ProductId', $ProductId);
    $stat->execute();
    header("location: seller_interface.php");
    } 
    catch(PDOException $e){
        echo $e->getMessage();
   
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product</title>
    <link rel="stylesheet" href="css/modify.css">

</head>
<body>
    <nav>
        <a href="seller_interface.php">Back</a>
        <a href="front.php">Front</a>
    </nav>
    <main>
        <form action="modify.php?id=<?php echo $_GET['id']?>" method="POST">
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
            <input type="submit" value="modifier" name="modify">
        </form>
    </main>
</body>
</html>

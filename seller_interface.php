<?php
require('connection.php');
try{
    $req='SELECT * from product ';
    $res=$con->query($req);
}
catch(Exception $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="css/seller_interface.css">
</head>
<body>
<nav>
        <a href="seller_interface.php">Back</a>
        <a href="front.php">Front</a>
    </nav>
    <a href='add_product.php'><button class="button-33">Add Product</button></a>
    <a href='orderslist.php'><button class="button-33">Manage Orders</button></a>
    <table border='1'>

        <tr>
            <th>Name</th>
            <th>Quantity in Stock</th>
            <th>Price</th>
            <th>Category</th>
            <th>Description</th>
            <th>photo </th>
            <th>Operation</th>

        </tr>
        <?php    
        foreach($res as $index){
        ?>  
        <tr>
            <td> <?php echo htmlspecialchars($index['Name']) ?></td>
            <td> <?php echo htmlspecialchars($index['Stock']) ?> </td>
            <td> <?php echo htmlspecialchars($index['Price']) ?> </td>
            <td> <?php echo htmlspecialchars($index['CategoryId']) ?> </td>
            <td class="Description"> <?php echo htmlspecialchars($index['Description']) ?> </td>
            <td><img id="pci" src="images/<?php echo htmlspecialchars($index['photo']); ?>"  alt="product_pic"></td>
            <td><a  onclick="return confirm('Are you sure that you want to delete this row?');" href="delete.php?id=<?php echo $index["ProductId"]; ?>"><img id="icon" src="images/delete-icon.png" alt="delete"></a><a href="modify.php?id=<?php echo $index["ProductId"]; ?>"><img id="icon" src="images/edit.png" alt="Edit"></a></td>
            
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
    
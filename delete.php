<?php
require('connection.php');
$ProductId =$_GET['id'];
try{
    $req="DELETE FROM product WHERE ProductId=:id";
    $stmt=$con->prepare($req);
    $stmt->bindParam(':id',$ProductId );
    $stmt->execute();
    header('location: seller_interface.php');
}
catch(PDOException $e){
    echo $e->getMessage();
}



?>

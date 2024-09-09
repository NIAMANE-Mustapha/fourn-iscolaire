<?php
$user = "LOUBNA";
$pass = "mustapha123";
$server = "localhost";
$dbname = "e-com";

try {
    $con = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
    // Set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
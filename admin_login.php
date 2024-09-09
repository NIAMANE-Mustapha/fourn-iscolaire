<?php
require("connection.php");
session_start();

if (isset($_POST["Login"])) {
    $L_Email = $_POST["Email"];
    $L_Password = $_POST["Password"];

    try {
		$req="SELECT * from admin where Email=:Email and Password=:Password";
		$stmt=$con->prepare($req);
		$stmt->bindParam(':Email',$L_Email);
		$stmt->bindParam(':Password',$L_Password);
		$stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
                header("Location: seller_interface.php");
                exit(); // Make sure to exit after the redirection
            
        } else {
            echo "No Admin found with that email address.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="css/admin_login.css">
</head>
<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container d-flex justify-content-center">
        <a class="navbar-brand" href="front.php">
            <img src="images/logo1.png" alt="Company Logo" class="d-inline-block align-middle logo">
        </a>
    </div>
	</nav>


	<div class="main">	
			<div class="login">
				<form action="admin_login.php" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="Email" placeholder="Email" required>
					<input type="password" name="Password" placeholder="Password" required>
					<input type="submit" value="Login" name="Login">
				</form>
			</div>
	</div>
</body>
</html>
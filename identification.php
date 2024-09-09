<?php
require("connection.php");
if (isset($_POST["Sign_up"])){
	$ClientName=$_POST["n_ClientName"];
	$Email=$_POST["n_Email"];
	$Phone=$_POST["n_Phone"];
	$Password=$_POST["n_Password"];
	$Address=$_POST["n_Address"];
	try{
		$req="INSERT INTO client (ClientName,Address,Phone, Password, Email) VALUES(:ClientName,:Address,:Phone,:Password,:Email)";
		$stmt=$con->prepare($req);
		$stmt->bindParam(':ClientName',$ClientName);
		$stmt->bindParam(':Address',$Address);
		$stmt->bindParam(':Email',$Email);
		$stmt->bindParam(':Password',$Password);
		$stmt->bindParam(':Phone',$Phone);
		$stmt->execute();
	}

	catch(PDOException $e){
		echo $e->getMessage();
	}
}
session_start();

if (isset($_POST["Login"])) {
    $L_Email = $_POST["Email"];
    $L_Password = $_POST["Password"];

    try {
		$req="SELECT * from client where Email=:Email and Password=:Password";
		$stmt=$con->prepare($req);
		$stmt->bindParam(':Email',$L_Email);
		$stmt->bindParam(':Password',$L_Password);
		$stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Assuming your password is hashed in the database

                $_SESSION['logged_in'] = 1;
				$_SESSION['Name']=$result['ClientName'];
				$_SESSION['Clientid']=$result['ClientId'];
				$_SESSION["address"]=$result['Address'];
				echo $_SESSION['Name'];

                $_SESSION['user_email'] = $L_Email; // Optionally store the user's email or other details
                header("Location: front.php");
                exit(); // Make sure to exit after the redirection
            
        } else {
            echo "No user found with that email address.";
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
	<link rel="stylesheet" type="text/css" href="css/identification.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
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
	<div class="main">
		<h3><? echo $error ?></h3>  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="identification.php" method="POST">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="n_ClientName" placeholder="Full Name" required="">
					<input type="email" name="n_Email" placeholder="Email" required="">
                    <input type="tel" name="n_Phone" placeholder="Phone" required="">
					<input type="password" name="n_Password" placeholder="Password" required="">
					<input type="text" name="n_Address" placeholder="Address" required="">
					<input type="submit" value="Sign up" name="Sign_up">
				</form>
			</div>

			<div class="login">
				<form action="identification.php" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="Email" placeholder="Email" required>
					<input type="password" name="Password" placeholder="Password" required>
					<input type="submit" value="Login" name="Login">
				</form>
			</div>
	</div>
</body>
</html>
<?php 
	session_start();
	
	require_once 'config/connect.php'; 
	if(isset($_POST) & !empty($_POST)) {

	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	echo $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
	
	$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
	
	if($result) {

		$_SESSION['customer'] = $email;
		$_SESSION['customerid'] = mysqli_insert_id($connection);
		
		header("location: cart.php");
	}
	
	else { 

		header("location: login.php?message=2");
	}
}

?>

<?php

	session_start();
	unset($_SESSION['cart']);
	unset($_SESSION['customer']);

	header("Location: index.php");
?>

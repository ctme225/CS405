<?php
session_start();
if(isset($_SESSION["username"])){
	header("Location: index.php");
}

 $db = mysqli_connect('localhost','root','','clayton_db')
 or die('Error connecting to MySQL server.');

if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["type"])){
	
	$query = "INSERT INTO `users` (`username`, `password`, `type`)
			VALUES ('".$_POST["username"]."', '".$_POST["password"]."', '".$_POST["type"]."')";

	if(mysqli_query($db, $query)) echo "Registration successful";
	else{
		echo("Error description: " . mysqli_error($db));
	}

}

mysqli_close($db);
?>
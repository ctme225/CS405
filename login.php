<?php
//Step2

 $db = mysqli_connect('localhost','root','','clayton_db')
 or die('Error connecting to MySQL server.');

if(isset($_POST["username"]) && isset($_POST["password"])){
	$query = "SELECT * FROM `users` WHERE `username`='".$_POST["username"]."' AND `password`='".$_POST["password"]."' LIMIT 1";

	if(mysqli_query($db, $query));
	else{
		echo("Error description: " . mysqli_error($db));
	}


	$result = mysqli_query($db, $query);
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);



	if($num_rows) {
		echo "Login successful";
		session_start();

		$_SESSION["username"] = $_POST["username"];
		$_SESSION["user_type"] = $row['type'];
		$_SESSION["user_id"] = $row['id'];

		if((int)$row['type']==1)
			header("Location: host_user.php");
		else
			header("Location: visitor.php");
	}
	else echo "Wrong username or password";
}



mysqli_close($db);
?>
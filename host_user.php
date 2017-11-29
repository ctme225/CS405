<?php
$db = mysqli_connect('localhost','root','','clayton_db')
or die('Error connecting to MySQL server.');
session_start();
if(!isset($_SESSION["username"])){
	header("Location: index.php");
}
if(((int)$_SESSION["user_type"]==2)){
	header("Location: visitor.php");
}
echo $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User panel</title>
	</head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<body>
		<a href="logout.php">
			<button type="button">Log Out</button>
			<b>Hello host user</b>
		</a>
		<br>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3>
					Create yard sales
					</h3>
					<form action="" method="POST">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit name</label>
							<input type="text" class="form-control" name="name">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Number of items</label>
							<input type="number" class="form-control" name="item">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
				<div class="col-md-6">
					<h3>
					Your yards on sale
					</h3>
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Name</th>
								<th scope="col">Units added</th>
								<th scope="col">Units Sold</th>
								<th scope="col">Edit/Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							//Step2
							$query = "SELECT * FROM `yards` WHERE `host_user_id`='".$_SESSION["user_id"]."'";
													mysqli_query($db, $query) or die('Error querying database.');
							//Step3
							$result = mysqli_query($db, $query);
												// $row = mysqli_fetch_array($result)
							while ($row = mysqli_fetch_array($result)) {
							echo "<tr>
										<td>".$row["id"]."</td>
										<th scope='row' id='name_".$row["id"]."'>".$row["name"]."</th>
										<td id='items_".$row["id"]."'>".$row["no_items"]."</td>
										<td id='sold_".$row["id"]."'>".$row["no_sold"]."</td>
										<td><button id=".$row["id"]." class='edit'>Edit</button> | Delete</td>
								</tr>";
							}
							
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit Yard Sale</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Yard ID</label>
							<input type="text" class="form-control" name="edit_yard_id" id="yard_id">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Unit name</label>
							<input type="text" class="form-control" name="edit_name" id="edit_name">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Number of items</label>
							<input type="number" class="form-control" name="edit_item" id="edit_item">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Number of items sold</label>
							<input type="number" class="form-control" name="edit_sold" id="edit_sold">
						</div>
						<form action="" method="POST">
						<div class="form-group">
							<label for="exampleInputEmail1">Delete Yard ID</label>
							<input type="text" class="form-control" name="delete_id" id="delete_id">
						</div>
						<button type="submit" class="btn btn-primary">Delete</button>
					</form>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script>
	$(".edit").click(function(){
		// alert($(this).attr("id"));
		$("#yard_id").val($(this).attr("id"));
		$("#delete_id").val($(this).attr("id"));
		$("#edit_name").val($("#name_"+$(this).attr("id")).text());
		$("#edit_item").val($("#items_"+$(this).attr("id")).text());
		$("#edit_sold").val($("#sold_"+$(this).attr("id")).text());
		$('#editModal').modal('show');
	});
</script>
<?php
if(isset($_POST["name"]) && isset($_POST["item"]) && ((int)$_SESSION["user_type"] == 1)){
	
	$query = "INSERT INTO `yards` (`name`, `no_items`, `host_user_id`)
			VALUES ('".$_POST["name"]."', '".$_POST["item"]."', '".$_SESSION["user_id"]."')";
	if(mysqli_query($db, $query)) echo "<h2> Yard added successfully </h2>";
	else{
		echo("Error description: " . mysqli_error($db));
	}
}

if(isset($_POST["edit_yard_id"]) && isset($_POST["edit_name"]) && isset($_POST["edit_item"]) && isset($_POST["edit_sold"])){
	
	$query = "UPDATE `yards`
				SET `name`='".$_POST["edit_name"]."', `no_items`='".$_POST["edit_item"]."',`no_sold`='".$_POST["edit_sold"]."'
				WHERE `id`='".$_POST["edit_yard_id"]."' AND `host_user_id`= '".$_SESSION["user_id"]."' ";

	if(mysqli_query($db, $query)) echo "<h2> Yard updated successfully </h2>";
	else{
		echo("Error description: " . mysqli_error($db));
	}
}

if(isset($_POST["delete_id"])){
	
	$query = "DELETE FROM `yards` WHERE id='".$_POST["delete_id"]."'";

	if(mysqli_query($db, $query)) echo "<h2> Yard deleted successfully </h2>";
	else{
		echo("Error description: " . mysqli_error($db));
	}
}

mysqli_close($db);
?>
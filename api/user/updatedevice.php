<?php
require_once("../dbcon.php");
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$sql="select * from devices where id=".$id;
$details = array();
if(!$result = $conn->query($sql)){
	echo $conn->error;
}
else
{
	while ($rows = $result->fetch_assoc()) {
		$details[] = $rows;
	}  
	//print_r($details); exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h1 class="text-center">Update Device</h1>
		<a href="index.php"><h3 class="text-center">Back</h3></a>
		<form action="update_action_page.php" method="post">
			<div class="form-group">
				<label for="number">Device Number:</label>
				<input type="hidden" name="id" value="<?=$details[0]['id']?>">
				<input type="number" class="form-control" name="num" value="<?=$details[0]['device_number']?>"  required>
			</div>
			<div class="form-group">
				<label for="name">Device Name:</label>
				<input type="text" class="form-control" name="name" value="<?=$details[0]['device_short_name']?>" required>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form> 
	</div>

</body>
</html>
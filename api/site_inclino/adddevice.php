<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
	.form-control {
		border-top: 0px !important;
		border-left: 0px !important;
		border-right: 0px !important;
		border-radius: 0px !important;
		box-shadow: none !important;
	}

	.form-group {
		margin-top: 15px !important;
	}
</style>

<body>

	<div class="container">
		<div class="panel panel-default col-md-4 col-md-offset-4" style="margin-top: 50px">

			<h3 class="text-center">Add New Device</h3>

			<div class="panel-body">
				<div class="row">
					<div class="form-group">
						<form action="add_action_page.php" method="post">
							<div class="form-group">
								<!-- <label for="number">Device Number:</label> -->
								<input type="number" class="form-control" name="num" placeholder="Enter device number" required>
							</div>
							<div class="form-group">
								<!-- <label for="name">Device Name:</label> -->
								<input type="text" class="form-control" name="name" placeholder="Enter device name" required>
							</div>
							<button type="submit" class="btn btn-success">Submit</button>
							<a class="btn btn-danger pull-right" href="index.php"><span>Back</span></a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	< </body>

</html>
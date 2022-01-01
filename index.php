<?php
	// include database and object files
	include_once './conn/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<title>Setting</title>
</head>
	<body>
		<div class="container">
			<h2>Source Database Setting</h2>
			<form class="form-horizontal" method="post" action="get_user_tiers.php">
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Host:</label>
					<div class="col-sm-10">
						<input type="text" value="localhost" class="form-control" placeholder="Enter" name="host">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">DB:</label>
					<div class="col-sm-10">
						<input type="text" value="fiverr_referers" class="form-control" placeholder="Enter" name="db">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Username:</label>
					<div class="col-sm-10">
						<input type="text" value="root" class="form-control" placeholder="Enter" name="uname">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="pwd">Password:</label>
					<div class="col-sm-10">          
						<input type="password" class="form-control" value="" placeholder="Enter password" name="pwd">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Table:</label>
					<div class="col-sm-10">
						<input type="text" value="users" class="form-control" placeholder="Enter" name="table">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="email">ID Field:</label>
					<div class="col-sm-10">
						<input type="text" value="id" class="form-control" placeholder="Enter" name="sid">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Public ID Field:</label>
					<div class="col-sm-10">
						<input type="text" value="uname" class="form-control" placeholder="Enter" name="pid">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Referer ID Field:</label>
					<div class="col-sm-10">
						<input type="text" value="referrer" class="form-control" placeholder="Enter" name="ref">
						<input type="hidden" value="db_create" name="db_create">
					</div>
				</div>

				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Check Connection</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
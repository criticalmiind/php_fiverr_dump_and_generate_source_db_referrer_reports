<?php
	// include database and object files
	include_once './conn/session.php';
	include_once './check_source_db.php';
?>
<?php
	
	if(isset($_POST['id']) && isset($_POST['tier'])){
		extract($_POST);
		$ref_usrs = $ref_report->get_list_by_user_id($id);
		if(count($ref_usrs) > 0){
			echo "<script>alert('This user already have records in referrer reports please delete old records first!')</script>";
		}else{
			$usr = $users->get_user_by_id($id);
			if(count($usr) > 0){
				$usr = $usr[0];
				$obj = (object) [
					"user_id" => $id,
					"tier" => $tier,
					"uname" => $usr['p_id'],
				];
				$ref_report->create($obj);
			}else{
				echo "<script>alert('This user id not found in source db!')</script>";
			}
		}
	}

	if(isset($_POST['delete'])){
		extract($_POST);
		$ref_report->delete($report_id);
		$report_trnx->delete_by_report_id($report_id);
		echo "<script>alert('Report deleted successfully!')</script>";
	}
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
			<h2>Create User Referer Report</h2>
			<form class="form-horizontal" method="post" action="get_user_tiers.php">
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">User ID:</label>
					<div class="col-sm-10">
						<input type="text" value="2701" class="form-control" placeholder="Enter UserID" name="id">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Enter No of Tier:</label>
					<div class="col-sm-10">
						<input type="text" value="5" class="form-control" placeholder="Enter" name="tier">
					</div>
				</div>

				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Generate Report</button>
					</div>
				</div>
			</form>

			<table class="table">
				<thead>
				<tr>
					<th>Report ID</th>
					<th>User ID</th>
					<th>Public ID</th>
					<th>No of Tier</th>
					<th>Status</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$l = $ref_report->get_list();
						foreach ($l as $r) {
							$s = '';
							if($r['status'] == 0) $s = 'Pending';
							if($r['status'] == 1) $s = 'Processing';
							if($r['status'] == 2){
								$s = '<a href="view_report.php?report_id='.$r['report_id'].'">View Report</a><br/>';

								$s .= '<a href="#" onclick="';
								$s .= "if(confirm('Are you sure you want to delete this report?')){ event.preventDefault();document.getElementById('delete-form-".$r['report_id']."').submit(); }";
								$s .= '">Delete</a>';

								$s .= '<form id="delete-form-'.$r['report_id'].'" action="get_user_tiers.php" method="post">';
								$s .= '<input type="hidden" name="report_id" value="'.$r['report_id'].'">';
								$s .= '<input type="hidden" name="delete" value="abc">';
								$s .= '</form>';
							}

							echo "<tr>
								<td>".$r['report_id']."</td>
								<td>".$r['user_id']."</td>
								<td>".$r['mainUser']."</td>
								<td>".$r['tier']."</td>
								<td>".$s."</td>
							</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>
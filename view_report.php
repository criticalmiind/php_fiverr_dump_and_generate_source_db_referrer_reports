<?php
	// include database and object files
	include_once './conn/session.php';
	include_once './check_source_db.php';
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
			<div class="row">
				<div class="col-md-6">
					<h2>User Referrers Report</h2>
				</div>
				<div class="col-md-6 text-right">
					<a href="export_csv.php?report_id=<?= $_GET['report_id'] ?>" class="btn btn-sm btn-primary" style="margin-top: 20px;margin-bottom: 10px;">Download CSV</a>
				</div>
			</div>
			<table class="table">
				<thead>
				<tr>
					<th>Txn ID</th>
					<th>Report ID</th>
					<th>User ID</th>
					<th>Public ID</th>
					<th>Referrer ID</th>
					<th>No of Tier</th>
				</tr>
				</thead>
				<tbody>
					<?php
						if(isset($_GET['report_id'])){
							extract($_GET);
							$reports = $report_trnx->get_report_by_id($report_id);
							if(count($reports) > 0){
								foreach ($reports as $r) {
									echo "<tr>
										<td>".$r['txn_id']."</td>
										<td>".$r['report_id']."</td>
										<td>".$r['user_id']."</td>
										<td>".$r['public_id']."</td>
										<td>".$r['referrer']."</td>
										<td>".$r['tier']."</td>
									</tr>";
								}
							}else{
								echo "<script>alert('no record found of this report id in dump db!')</script>";
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>
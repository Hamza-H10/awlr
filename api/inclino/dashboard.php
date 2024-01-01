<?php
include('include/header.php');
// include __DIR__ . '/../../include/header.php'; 
?>
<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap-theme.min.css" rel="stylesheet">

<style>
	.cwhite {
		color: #FFFFFF
	}

	.body-container {
		/* background: url(Doc2-1.jpg); */
		background-repeat: repeat;
		background-position-x: 0%;
		background-position-y: 0%;
		background-size: auto auto;

		background-size: auto auto;
		background-size: contain;
		background-repeat: no-repeat;
		background-position-x: center;
	}

	.body-container {
		min-height: 500px
	}
</style>
<div class="body-container">

	<div class="container">
		<div class="row">


			<?php
			function total_bill()
			{
				global $db;
				$stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' ");
				$stmt->execute();
				return $stmt->rowCount();
			}

			function total_company()
			{
				global $db;
				$stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' GROUP BY gst_no ");
				$stmt->execute();
				return $stmt->rowCount();
			}

			function total_payed()
			{
				global $db;
				$pay = '';
				$stmt3 = $db->prepare("SELECT * FROM tbl_payment ");
				$stmt3->execute();
				while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
					$pay = $pay + $row3['amount_paid'];
				}
				return $pay;
			}


			function total_unpayed()
			{
				global $db;
				$unpay = '';
				$stmt3 = $db->prepare("SELECT * FROM tbl_invoice_data ");
				$stmt3->execute();
				while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
					$unpay = $unpay + $row3['total'];
				}
				$unpay = $unpay - total_payed();

				if ($unpay < 0) {
					$unpay = 0;
				}
				return $unpay;
			}

			?>




		</div>

		<div class="row">


			<div class="col-md-12" style="margin-top:15px">
				TESTING INCLINO
				<?php

				if ($core_user_role == 0 or $core_user_role == 1) {
					$stmt = $db->prepare("SELECT * FROM inclino_tbl_users WHERE user_id=:uid");
					$stmt->execute(array(":uid" => $_SESSION['user_session']));
					$temp_array = explode(',', $row['mobile']);
					foreach ($temp_array as $temp_val) {
						echo '<div>';
						echo '<a href="' . url() . 'doc/' . $core_user_email . '/' . $temp_val . '" target="_blank">' . $temp_val . '</a>';

						echo '</div>';
					}
				}

				?>

			</div>

		</div>

	</div>

	<div class="panel-footer" style="position: fixed;
width: 100%;
bottom: 0px;">

	</div>
</div>

<?php include('include/footer.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student Information Form</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.profile-img {
			width: 150px;
			height: 150px;
			object-fit: cover;
			border-radius: 50%;
			margin-bottom: 20px;
		}

		.section {
			margin-bottom: 30px;
			border: 1px solid #ddd;
			padding: 15px;
			border-radius: 5px;
		}

		.section h4 {
			background-color: #d2e2ef;
			padding: 10px;
			border-radius: 5px;
		}

		.info-box {
			background-color: #e9ecef;
			padding: 10px;
			border-radius: 5px;
		}

		.RctBtnWrap {
			margin-top: -54px;
			position: fixed;
			right: 1.5em;
			z-index: 999;
		}

		.btm_wrapper {
			display: flex;
			justify-content: space-around;
		}

		@media print {
			.RctBtnWrap {
				display: none;
			}
		}
	</style>
</head>

<body>
	<div class="RctBtnWrap mb-5" id="test">
		<a class="btn btn-lg btn-warning" href="javascript:window.print();">Print</a>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-3 text-center">
				<img src="<?php echo '/webroot/uploads/students/thumbnail/' . $students['thumbnail']; ?>" alt="Profile Picture" class="profile-img">
			</div>
			<div class="col-md-9">
				<div class="section">
					<h4>Student Information</h4>
					<div class="info-box">
						<p>Name: <?php echo $students['name']; ?></p>
						<p>Student ID: <?php echo $students['student_sid']; ?></p>
						<p>Present Address: <?php echo $students['present_address']; ?></p>
						<p>Permanent Address: <?php echo $students['permanent_address']; ?></p>
						<p>DOB: <?php echo $students['date_of_birth']; ?></p>
						<p>Birth Registration: <?php echo $students['birth_registration']; ?></p>
						<p>Gender: <?php echo $students['gender']; ?></p>
						<p>Religion: <?php echo $students['religion']; ?></p>
					</div>
				</div>
				<div class="section">
					<h4>Academic Information</h4>
					<div class="info-box">
						<p>Class: <?php echo $students['level_name']; ?></p>
						<p>Section: <?php echo $students['section_name']; ?></p>
						<p>Shift: <?php echo $students['shift_name']; ?></p>
						<p>Session: <?php echo $students['session_name']; ?></p>
						<p>Roll: <?php echo $students['roll']; ?></p>
					</div>
				</div>
				<div class="section">
					<div class="row">
						<div class="col-md-6">
							<h4>Father Information</h4>
							<div class="info-box">
								<p>Name: <?php echo $students['father_name']; ?></p>
								<p>Mobile: <?php echo $students['father_mobile']; ?></p>
								<p>nid: <?php echo $students['father_nid']; ?></p>
							</div>
						</div>
						<div class="col-md-6">
							<h4>Mother Information</h4>
							<div class="info-box">
								<p>Name: <?php echo $students['mother_name']; ?></p>
								<p>Mobile: <?php echo $students['mother_mobile']; ?></p>
								<p>nid: <?php echo $students['mother_nid']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
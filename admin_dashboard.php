<?php
session_start();

include 'database/config.php';
include 'database/opendb.php';

function numberOfActiveEntities($entity)
{
	include 'database/config.php';
	include 'database/opendb.php';

	$sql = "SELECT COUNT(*)
			FROM " . $entity . "
			WHERE IS_ACTIVE = 1";

	$execute = mysqli_query($conn, $sql);

	if ($execute) {
		$row = mysqli_fetch_array($execute);
		$count = $row[0];
		include 'database/closedb.php';

		return $count;
	} else {
		include 'database/closedb.php';
		return 0;
	}

}

include 'database/closedb.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords"
		content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Welcome Admin</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<style>
		.containercount {
			width: 28vmin;
			height: 28vmin;
			display: flex;
			align-items: center;
			flex-direction: column;
			justify-content: space-around;
			padding: 1em 0;
			position: relative;
			font-size: 16px;
			border-radius: 0.5em;
			background-color: #222e3c;
			border-bottom: 10px solid lightgray;
			border-top: 2px solid lightgray;
			border-right: 2px solid lightgray;
			border-left: 2px solid lightgray;
			margin-left: 35px;
		}


		.containercount i {
			color: white;
			transform: scale(2);

		}

		span.num {
			color: white;
			display: grid;
			place-items: center;
			font-weight: 600;
			font-size: 3em;
			font-family: Verdana;
		}

		span.text {
			color: white;
			font-size: 1em;
			text-align: center;
			pad: 0.7em 0;
			font-weight: 400;
			line-height: 0;
			font-family: Verdana;
			font-weight: bold;
		}

		.center {
			display: flex;
			align-items: center;
		}

		.dashboard-title {
			font-size: 36px;
			font-weight: bold;
			font-family: 'Open Sans', sans-serif;
			text-align: center;
			color: #222e3c;
			margin-bottom: 40px;
		}
	</style>

	<script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
</head>

<body>
	<div class="wrapper">
		<?php include "verticalNavBar.php"; ?>
		<div class="main">
			<?php include "horizontalNavBar.php"; ?>

			<main class="content">
				<div class="container-fluid p-0">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<div class="row">
										<div class="col-12 col-lg-12 d-flex justify-content-center">
											<div class="card-header">
												<script
													src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
													type="module"></script>
												<dotlottie-player
													src="https://lottie.host/8eb50c51-29f3-412c-86b3-4f6625771d99/TJCaE6cDsG.json"
													background="transparent" speed="1"
													style="width: 300px; height: 300px; margin-top: -100px" loop
													autoplay></dotlottie-player>
											</div>
										</div>
										<div class="col-12 col-lg-12 d-flex justify-content-center">
											<div class="card-header">
												<h1 class="dashboard-title">Active Entities</h1>
											</div>
										</div>


										<div class="col-12 col-lg-3">
											<div class="containercount">
												<i class="fa fa-users"></i>
												<span class="num"
													data-val="<?php echo numberOfActiveEntities('users'); ?>"></span>
												<span class="text">Active Users</span>
											</div>
										</div>
										<div class="col-12 col-lg-3">
											<div class="containercount">
												<i class="fa fa-building"></i>
												<span class="num"
													data-val="<?php echo numberOfActiveEntities('companies'); ?>"></span>
												<span class="text">Active Companies</span>
											</div>
										</div>
										<div class="col-12 col-lg-3">
											<div class="containercount">
												<i class="fa fa-cubes"></i>
												<span class="num"
													data-val="<?php echo numberOfActiveEntities('structures'); ?>"></span>
												<span class="text">Active Structures</span>
											</div>
										</div>
										<div class="col-12 col-lg-3">
											<div class="containercount">
												<i class="fa fa-sitemap"></i>
												<span class="num"
													data-val="<?php echo numberOfActiveEntities('departments'); ?>"></span>
												<span class="text">Active Departments</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>

			<script>
				function showCount() {
					var valueDisplays = document.querySelectorAll(".num");
					var interval = 500;
					valueDisplays.forEach((valueDisplay) => {
						let startValue = 0;
						let endValue = parseInt(valueDisplay.getAttribute("data-val"));
						if (endValue != 0) {
							let duration = Math.floor(interval / endValue);
							let counter = setInterval(function () {
								startValue += 1;
								valueDisplay.textContent = startValue;
								if (startValue == endValue) {
									clearInterval(counter);
								}
							}, duration);
						} else {
							valueDisplay.textContent = 0;
						}
					});
				}

				showCount();
			</script>

			<?php
			include "footer.php";
			?>
		</div>
	</div>

	<script src="js/app.js"></script>

</body>

</html>
<?php
session_start();
//require_onces database config
require_once("config.php");
// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: signin.php');
	exit;
}
// Check if the user has verified number or not
if ($_SESSION['user']['status']!=='success') {
	header('location: signin.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>DashBoard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karla">
	<link rel="stylesheet" href="assets/styles.css">
</head>

<body style="font-family: Karla, sans-serif;">
	<div class="page">
		<section class="register">
			<div class="form-container">

				<h2 class="text-center"><strong>User </strong> DashBoard.</h2>


				<div class="callout text-primary">
					Welcome <?php echo $_SESSION['user']['fullName']; ?>. Click here to <a href="logout.php" tite="Logout">Logout.

				</div>


			</div>
		</section>
	</div>
	</body>

</html>
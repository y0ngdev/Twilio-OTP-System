

<?php require_once('process.php') ?>
<?php
if(isset($_GET["session_expire"])) {
	$err_message .= "signin Session is Expired. Please signin Again";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Sign in-OTP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karla">
	<link rel="stylesheet" href="assets/styles.css">
</head>

<body style="font-family: Karla, sans-serif;">
	<div class="page">
		<section class="register">
			<div class="form-container">
				
				<form method="post">
					<h2 class="text-center"><strong>Sign in</strong> to your account.</h2>
					<?php if ($err_message) : ?>
						<div class="callout text-danger">

							<p><?php echo $err_message; ?></p>
						</div>
					<?php endif; ?>
					<div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
					<div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
					<div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="signin">Sign in</button></div><a class="already" href="signup.php">Don't have an account? Sign up here.</a>
				</form>
			</div>
		</section>
	</div>
</body>

</html>
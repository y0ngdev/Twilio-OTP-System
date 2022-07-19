<?php require_once('process.php');


$page = ((empty($_GET['p'])) ? '' : strval($_GET['p']));
$number = $_SESSION['phone'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Voice OTP</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karla">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="assets/styles.css">
</head>

<body style="font-family: Karla, sans-serif;">
	<div class="page">
	<?php if($page=='signup' && isset($_SESSION['phone'])):  ?>
		<section class="register">
			<div class="form-container">

				<form method="post">
					<h2 class="text-center"><strong>Verify</strong> your account.</h2>

					</p>A verification code has been sent through Voice call to
					<b><?php echo mask_no($number); ?></b>, <br />
					enter the code below to continue.</p>
					<?php if ($err_message) : ?>
						<div class="callout text-danger">

							<p><?php echo $err_message; ?></p>
						</div>
					<?php endif; ?>
					<div class="mb-3"><input class="form-control" type="text" name="code" placeholder="Code"></div>
					
					<div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="signup_verify">Verify</button></div><a class="already" href="signup.php">Wrong Number?</a>
				</form>
			</div>
		</section>
		<?php elseif($page=='signin'  && isset($_SESSION['phone'])):?>
		<section class="register">
			<div class="form-container">

				<form method="post">
					<h2 class="text-center"><strong>Verify</strong> your account.</h2>

					</p>A verification code has been sent through Voice call to
					<b><?php echo mask_no($number); ?></b>, <br />
					enter the code below to continue.</p>
					<?php if ($err_message) : ?>
						<div class="callout text-danger">

							<p><?php echo $err_message; ?></p>
						</div>
					<?php endif; ?>
					<div class="mb-3"><input class="form-control" type="text" name="code" placeholder="Code"></div>
					
					<div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="signin_verify">Verify</button></div>
				</form>
			</div>
		</section>
			<?php else: ?>
					
						<?php header('HTTP/1.0 403 Forbidden'); echo 'Error Cant access resource'; ?>
					
					<?php endif; ?>
	</div>
</body>

</html>
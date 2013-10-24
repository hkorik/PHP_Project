<?php

	session_start();

	if(isset($_SESSION['logged_in']))
	{
		header("Location: user_wall.php");
	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall Registration Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/styles.css" />
</head>
<body>
	<div id="register_wrapper">
		<div id="registration_box" class="float_left">
			<h2>Register or <a href="index.php">Login</a></h2>
			<?php
				if(isset($_SESSION['register_errors']))
				{
					foreach($_SESSION['register_errors'] as $error)
					{
						echo "<p class='error_message'>$error</p>";
					}
				}
			?>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="register" />
				<div class="<?php if(isset($_SESSION['register_errors']['email_error'])) echo 'field_block'; ?>">
					<label for="email">Email *</label><br/>
					<input type="text" name="email" id="email" placeholder="Email" />
				</div>	
				<div class="<?php if(isset($_SESSION['register_errors']['first_n_error'])) echo 'field_block'; ?>">
					<label for="first_name">First Name *</label><br/>
					<input type="text" name="first_name" id="first_name" placeholder="First Name" />
				</div>
				<div class="<?php if(isset($_SESSION['register_errors']['last_n_error'])) echo 'field_block'; ?>">
					<label for="last_name">Last Name *</label><br/>
					<input type="text" name="last_name" id="last_name" placeholder="Last Name" />
				</div>
				<div class="<?php if(isset($_SESSION['register_errors']['pw_error'])) echo 'field_block'; ?>">
					<label for="password">Password *</label><br/>
					<input type="password" name="password" id="password" placeholder="Password" />
				</div>
				<div class="<?php if(isset($_SESSION['register_errors']['confirm_pw_error'])) echo 'field_block'; ?>">
					<label for="confirm_password">Confirm Password *</label><br/>
					<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />
				</div>
				<input type="submit" value="Register" />
			</form>
			<?php unset($_SESSION['register_errors']); ?>
		</div>
	</div>
</body>
</html>
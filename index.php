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
	<title>Wall Log in Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/styles.css" />
</head>
<body>
	<div id="wrapper">
		<!-- Login right box -->
		<div id="login_box">
			<h2>Login or <a href="register.php">Register</a></h2>
			<?php
				if(isset($_SESSION['login_errors']))
				{
					foreach($_SESSION['login_errors'] as $error)
					{
						echo "<p class='error_message'>$error</p>";
					}
				}
			?>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="login" />
				<div class="<?php if(isset($_SESSION['login_errors']['email_error'])) echo 'field_block'; ?>">
					<label for="email">Email *</label><br/>
					<input type="text" name="email" id="email" placeholder="Email" />
				</div>	
				<div class="<?php if(isset($_SESSION['login_errors']['pw_error'])) echo 'field_block'; ?>">
					<label for="password">Password *</label><br/>
					<input type="password" name="password" id="password" placeholder="Password" />
				</div>
				<input type="submit" value="Login" />
			</form>
			<?php unset($_SESSION['login_errors']); ?>
		</div>
	</div>
</body>
</html>
<?php
	
	session_start();
	
	require('functions.php');

	$the_messages = get_message();

	if(!isset($_SESSION['logged_in']))
	{
		header("Location: index.php");
	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/styles.css" />
</head>
<body>
	<div id="wall_wrapper">
		<div id="header">
			<h1 class="float_left">CodingDojo Wall</h1>
			<p class="float_right">Welcome <?= $_SESSION['user']['first_name'] ?><a href="process.php">log off</a></p>
		</div>
		<div id="main_content">
			<form action="process.php" method="post">
				<h2>Post a message</h2>
				<input type="hidden" name="action" value="user_message" />
				<textarea name="message" id="message" rows=5 cols=73></textarea>
				<input class="float_right" type="submit" value="Post a message" id="message_button"/>
			</form>
			<div class="clear"></div>
			<?php
			
				if(isset($the_messages))
				{
					foreach ($the_messages as $message) 
					{
						echo "<h3>{$message['first_name']} {$message['last_name']} -  {$message['created_at']}</h3>";
						echo "<p class='messages'>{$message['message']}</p></br />";

						$comments = get_comments($message['id']);

						foreach ($comments as $comment) 
						{
							echo "<h3 id='comment_name'>{$comment['first_name']} {$comment['last_name']} -  {$comment['created_at']}</h3>";
							echo "<p id='comments'>{$comment['comment']}</p></br />";
						}
						
						echo "<form action='process.php' method='post' id='comment_form'>
							<h2>Post a comment</h2>
							<input type='hidden' name='action' value='comment' />
							<input type='hidden' name='message_id' value='{$message['id']}' />
							<textarea name='comment' id='comment' rows=5 cols=73></textarea>
							<input class='float_right' type='submit' value='Post a comment' id='comment_button' />
						</form><br/>";
					}
				}
				
			?>				
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
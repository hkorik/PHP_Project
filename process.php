<?php
	
	session_start();

	require("connection.php");

	//When user registers - run register function
	if(isset($_POST['action']) and $_POST['action'] == "register")
	{
		register_action();
	}
	//When user logs in - run login function
	else if (isset($_POST['action']) and $_POST['action'] == "login") 
	{
		login_action();
	}
	//When user messages - run message function
	else if(isset($_POST['action']) and $_POST['action'] == "user_message")
	{
		post_message();
	}
	//When user comments - run comment function
	else if (isset($_POST['action']) and $_POST['action'] == "comment") 
	{
		comment();
	}
	else
	{
		session_destroy();
		header("Location: index.php");
	}
//register button function
function register_action()
{	
	$errors = NULL;

	//Email validation
	if(empty($_POST['email']))
	{
		$errors['email_error'] = "Error: Email address cannot be blank!";
	}
	else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors['email_error'] = "Error: Email should be in valid format!";
	}

	//First name validation
	if(empty($_POST['first_name']))
	{
		$errors['first_n_error'] = "Error: First name field cannot be blank!";
	}
	else if (preg_match('#[0-9]#', $_POST['first_name'])) 
	{
		$errors['first_n_error'] = "Error: First name cannot contain numbers!";
	}

	//Last name validation
	if(empty($_POST['last_name']))
	{
		$errors['last_n_error'] = "Error: Last name field cannot be blank!";
	}
	else if (preg_match('#[0-9]#', $_POST['last_name'])) 
	{
		$errors['last_n_error'] = "Error: Last name cannot contain numbers!";
	}

	//Password validation
	if(empty($_POST['password']))
	{
		$errors['pw_error'] = "Error: Password field cannot be blank!";
	}
	else if(strlen($_POST['password']) < 6)
	{
		$errors['pw_error'] = "Error: Password must be greater than 6 charecters";
	}

	//Confirm password validation
	if(empty($_POST['confirm_password']))
	{
		$errors['confirm_pw_error'] = "Error: Confirm password field cannot be blank";
	}
	else if($_POST['confirm_password'] != $_POST['password'])
	{
		$errors['confirm_pw_error'] = "Error: Confirm password must match Password!";
	}
	
	//if there are any errors
	if(count($errors) > 0)
	{
		$_SESSION['register_errors'] = $errors;
		header("Location: register.php");
	}

	// if everything is correct!
	else
	{
		//check if user email exists
		$check_user = "SELECT * FROM users WHERE email = '{$_POST['email']}'";
		$user_exist = fetch_record($check_user);

		// if no one has that email address
		if($user_exist == NULL)
		{
			$new_user = "INSERT INTO users (email, password, first_name, last_name, created_at) VALUES ('{$_POST['email']}','" . md5($_POST['password']) . "','{$_POST['first_name']}','{$_POST['last_name']}', now() )";

			mysql_query($new_user);

			$check_user_info = "SELECT * FROM users WHERE email = '{$_POST['email']}' AND password = '" . md5($_POST['password']) . "'";

			$user_info = fetch_record($check_user_info);

			$_SESSION['user']['id'] = $user_info['id'];
			$_SESSION['user']['first_name'] = $user_info['first_name'];
			$_SESSION['user']['last_name'] = $user_info['last_name'];
			$_SESSION['logged_in'] = TRUE;

			if($_SESSION['logged_in'] == TRUE)
			{
				header("Location: user_wall.php?=" . $_SESSION['user']['id']);
			}
			
		}
		// if email already exists
		else
		{
			$errors['email_error'] = "Error: Email {$_POST['email']} is already in use!";
			$_SESSION['register_errors'] = $errors;
			header("Location: register.php");
		}
	}
}
//login button function
function login_action()
{	

	$errors_login = NULL;

	//Email validation
	if(empty($_POST['email']))
	{
		$errors_login['email_error'] = "Error: Email address cannot be blank!";
	}
	else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors_login['email_error'] = "Error: Email should be in valid format!";
	}

	//Password validation
	if(empty($_POST['password']))
	{
		$errors_login['pw_error'] = "Error: Password field cannot be blank!";
	}
	else if(strlen($_POST['password']) < 6)
	{
		$errors_login['pw_error'] = "Error: Password length must be at least 6 charecters!";
	}

	//if there are any error
	if(count($errors_login) > 0)
	{
		$_SESSION['login_errors'] = $errors_login;

		header("Location: index.php");
	}

	// if everything is correct!
	else
	{
		$check_user_info = "SELECT * FROM users WHERE email = '{$_POST['email']}' AND password = '" . md5($_POST['password']) . "'";
		
		$user_info = fetch_record($check_user_info);
		
		if($user_info != NULL)
		{
			$_SESSION['user']['id'] = $user_info['id'];
			$_SESSION['user']['first_name'] = $user_info['first_name'];
			$_SESSION['user']['last_name'] = $user_info['last_name'];
			$_SESSION['logged_in'] = TRUE;

			if($_SESSION['logged_in'] == TRUE)
			{
				header("Location: user_wall.php?=" . $_SESSION['user']['id']);
			}

		}
		else
		{
			$errors[] = "Error: The information entered does not match any of our records!";
			$_SESSION['login_errors'] = $errors;
			header("Location: index.php");
		}	
	}
}
//post message button function
function post_message()
{
	$new_message = "INSERT INTO messages (user_id, message, created_at) VALUES ('{$_SESSION['user']['id']}', '" . $_POST['message'] . "', now() )";

	mysql_query($new_message);

	header("Location: user_wall.php?=" . $_SESSION['user']['id']);
}

//comment message button function
function comment()
{

	$new_comment = "INSERT INTO comments (user_id, message_id, comment, created_at) VALUES ('{$_SESSION['user']['id']}', '{$_POST['message_id']}', '{$_POST['comment']}', now() )";

	mysql_query($new_comment);

	header("Location: user_wall.php?=" . $_SESSION['user']['id']);
}

?>
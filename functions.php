<?php

require('connection.php');

//get messages from database
function get_message()
{
	$get_message_query = "SELECT t1.first_name, t1.last_name, t2.id, t2.message, DATE_FORMAT(t2.created_at,'%M %D %Y') as created_at FROM messages AS t2 LEFT JOIN users AS t1 ON t1.id = t2.user_id ORDER BY t2.created_at DESC";

	$all_user_messages = fetch_all($get_message_query);

	return $all_user_messages;

}
//get comments from database
function get_comments($message_id) //uses message id number
{
	$get_comment_query = "SELECT t1.comment, t1.message_id, DATE_FORMAT(t1.created_at, '%M %D %Y') as created_at, t3.first_name, t3.last_name FROM comments as t1 LEFT JOIN messages as t2 ON t1.message_id = t2.id LEFT JOIN users as t3 ON t3.id = t1.user_id WHERE t1.message_id = {$message_id} ORDER BY t2.created_at ASC";

	$message_comments = fetch_all($get_comment_query);

	return $message_comments;
}
?>
<?php
session_start();
include("includes/connection.php");

	if(isset($_GET['post_id']))
	{
		$post_id=$_GET['post_id'];
		$query = "DELETE FROM posts WHERE post_id='$post_id'";
		$result   = $conn->query($query);
		echo "<script>alert('Post Deleted')</script>";
		echo "<script>window.open('home.php' , '_self')</script>";
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>    
<?php
session_start();
include("includes/connection.php");
if(isset($_POST['login']))
{
	$email=$conn->real_escape_string($_POST['email']);
	$pass=$conn->real_escape_string($_POST['pass']);
		
	$query = "SELECT * FROM users WHERE user_email='$email' AND user_pass='$pass'";
	$result   = $conn->query($query);	
	$rows = $result->num_rows;
		
	if($rows==1)
	{
		$_SESSION['user_email']=$email;
		$query = "UPDATE users SET user_last_login=CURRENT_TIMESTAMP WHERE user_email='$email'";
		$result   = $conn->query($query);
		echo "<script>window.open('home.php' , '_self')</script>";
	}
	else		
		echo "<p><a href='index.php'>Incorrect Details. Try Again</p>";
}
?>
</body>
</html>

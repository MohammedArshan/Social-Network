<?php
include("connection.php");

function insertPost()
{
	if(isset($_POST['mypost']))
	{
		global $conn;
		global $user_id;
		$content=addslashes($_POST['content']);
		$query = "INSERT INTO posts VALUES(null, '$user_id', '$content', CURRENT_TIMESTAMP)";
		$result   = $conn->query($query);

		$query = "UPDATE users SET posts='yes' WHERE user_id='$user_id'";
		$result   = $conn->query($query);	
		
		echo "<script>window.open('home.php' , '_self')</script>";
	}
}

function getPosts()
{
	global $conn;
	global $user_id;
	global $user_name;
	global $user_image;
	
	$query  = "SELECT * FROM posts ORDER BY 1 DESC";
	$result = $conn->query($query); 
	$rows = $result->num_rows;
	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		$query  = "SELECT * FROM users WHERE user_id='$row[1]'";
		$result1 = $conn->query($query);
		$row1 = $result1->fetch_array(MYSQLI_NUM);
		
		echo "<div id='posts11'>";
		echo "<img src='images/$row1[7]' width='50'  height='50' style='float: left; margin-right: 20px;'>";
		echo "<h3 style='margin-bottom: 10px;'><a href='user_profile.php?profile_id=$row1[0]' style='text-decoration: none; color: black;'>$row1[1]</a></h1>";
		echo "<p>$row[3]</p>";
		echo "<br>";
		echo "<p>$row[2]</p>";
		echo "</div>";
		echo "<div id='comment'>";
		echo "<p><a href='single_post.php?post_id=$row[0]&com_user_id=$user_id&com_user=$user_name&com_user_image=$user_image' style='text-decoration: none; color: black;'>more...</a></p>";
		echo "</div>";
	}
}

function insertComment()
{
	global $conn;
	global $post_id;
	if(isset($_POST['comment']))
	{
		$com_user_id=$_GET['com_user_id'];
		$com_user=$_GET['com_user'];
		$com_user_image=$_GET['com_user_image'];
		$com_text=addslashes($_POST['comment_text']);
		$query = "INSERT INTO comment VALUES(null, '$post_id', '$com_user_id', '$com_text', '$com_user', CURRENT_TIMESTAMP, '$com_user_image')";
		$result   = $conn->query($query);	
	}
	
		$query  = "SELECT * FROM comment WHERE post_id='$post_id' ORDER BY 1 DESC";
		$result = $conn->query($query); 
		$rows = $result->num_rows;
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			echo "<div>";
			echo "<img src='images/$row[6]' width='40'  height='40' style='float: left;  border-radius: 30px'>";
			echo "</div>";
			echo "<div id='commentspost'>";
			echo "<span style='margin-bottom: 10px;'><a href='user_profile.php?profile_id=$row[2]' style='text-decoration: none; color: black;'><b>$row[4]</b></a></span>";
			echo "<span>:  <span>";
			echo "<span>$row[3]</span>";
			echo "<p style='text-align:right; color: #979797'>$row[5]</p>";
			echo "</div>";
		}
}


function editPost()
{
	global $conn;
	global $post_id;
	if(isset($_POST['update']))
	{
		$newpost=addslashes($_POST['newpost']);
		$query = "UPDATE posts SET post_content='$newpost' WHERE post_id='$post_id'";
		$result   = $conn->query($query);	
		echo "<script>window.open('edit_posts.php?post_id=$post_id' , '_self')</script>";
	}
}
?>
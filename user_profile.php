<?php
session_start();
include("includes/connection.php");
include("includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles/home_style.css">
  </head>
  <body>
      <div id="header">
           <ul id="menu">
				<li><a href="home.php">Home</a></li>
				<li><a href="members.php">Members</a></li>				
		   </ul>	
		   <input type="text" name="search_text" id="search_text" placeholder="Search Members">			
      </div>
	  <br>
      <div id="content">
	  <br>
	  <br>
        <div id="left_wrapper">
			<div id="user_details">
				
				<?php
				$user=$_SESSION['user_email'];
				$query  = "SELECT * FROM users WHERE user_email='$user'";
				$result = $conn->query($query);
				$row = $result->fetch_array(MYSQLI_NUM);
				
				$user_id = $row[0];
				$user_name = $row[1];
				$user_country = $row[4];
				$user_image = $row[7];
				$register_date = $row[8];
				$last_login = $row[9];
				
				echo "<img src='images/$user_image' width='175'  height='175'>";
				echo "<p><b>Name: </b>$user_name</p>";
				echo "<p><b>Country: </b>$user_country</p>";
				$substring=substr($last_login,0,10);
				echo "<p><b>Last Login: </b>$substring</p>";
				$substring=substr($register_date,0,10);
				echo "<p><b>Since: </b>$substring</p>";

				$query  = "SELECT * FROM posts WHERE user_id='$user_id'";
				$result = $conn->query($query);
				$no_of_posts = $result->num_rows;
				echo "<p><a href='my_posts.php?u_id=$user_id&u_name=$user_name&u_image=$user_image'>My Posts($no_of_posts)</a></p>";
								
				
				echo "<p><a href='my_messages.php?u_id=$user_id'>Messages</a></p>";
				echo "<p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>";				
				echo "<p><a href='logout.php'>Logout</a></p>";				
				?>
			</div>
        </div>
		<div id="timeline">	
			<h2>User Profile</h2>
			<?php
				$profile_id=$_GET['profile_id'];
				$query  = "SELECT * FROM users WHERE user_id='$profile_id'";
				$result = $conn->query($query); 
				$row = $result->fetch_array(MYSQLI_NUM);
		
				echo "<div id='profile'>";
				echo "<div>";
				echo "<img src='images/$row[7]' width='120'  height='120' style='float: left; margin:6px 30px 0px 10px;'>";
				echo "</div>";
				echo "<h3 style='margin-bottom: 10px;'>$row[1]</h1>";
				echo "<p><b>Country: </b>$row[4]</p>";
				echo "<br>";
				echo "<p><b>Birthday:</b> $row[5]</p>";
				echo "<br>";
				$substring=substr($row[8],0,10);
				echo "<p><b>Since: </b>$substring</p>";
				echo "</div>";			
			?>
			<br>
			<button id='slidetoggle'>Message <?php echo $row[1] ?></button>
			<form id="messageform" action="" method="post">
			<textarea name="message_text" placeholder="Write your meassage" rows="3" cols="60"></textarea>
			<br>
			<input type="submit" value="Send" name="sendmessage" style="height: 35px; margin-bottom: 10px;"/> 
			</form>
			<?php
			if(isset($_POST['sendmessage']))
			{
			$message_text=addslashes($_POST['message_text']);
			$query = "INSERT INTO messages VALUES(null, '$user_id', '$profile_id', '$message_text',  CURRENT_TIMESTAMP)";
			$result   = $conn->query($query);	
			}
			?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<script>
				$('#messageform' ).hide();
				$('#slidetoggle').click(function() { $('#slidetoggle').hide(); })
				$('#slidetoggle').click(function() { $('#messageform').slideToggle('slow'); })
			</script>	
		</div>
	<div id="result"></div>
      </div>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script>
		$('#search_text').keyup(function() {
			var txt = $(this).val();
			if(txt!='')
			{
				$.ajax({
					url: "search.php",
					method: "post",
					data: {search_string:txt},
					dataType: "text",
					success: function(data)
					{
						$('#result').html(data);
					}
				});
			}
			else
			{
				$('#result').html('');
			}
		});
	  </script>
  </body>
</html>
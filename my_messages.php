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
      <div id="content">
	  <br>
	  <br>
        <div id="left_wrapper">
			<div id="user_details">
				<br>
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
				<br>	
				<h2>My Messages</h2>
				<br>
				<?php
				$user_id=$_GET['u_id'];
				$query  = "SELECT * FROM messages WHERE sender_id='$user_id' OR receiver_id='$user_id' ORDER BY 1 DESC";
				$result = $conn->query($query); 
				$rows = $result->num_rows;
				
				$x = array();			
				for ($j = 0 ; $j < $rows ; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_NUM);
		
				if($user_id==$row[1])
					$otherperson = $row[2];
				if($user_id==$row[2])
					$otherperson = $row[1];
		
				if(!in_array($otherperson, $x))
					$x[$row[0]] = $otherperson;
				}
				$query1  = "SELECT * FROM messages WHERE sender_id='$user_id' OR receiver_id='$user_id' ORDER BY 1 DESC";
				$result1 = $conn->query($query1); 
				$rows1 = $result1->num_rows;
	
				for ($k = 0 ; $k < $rows1 ; ++$k)
				{
				$result1->data_seek($k);
				$row1 = $result1->fetch_array(MYSQLI_NUM);
		
				if(array_key_exists($row1[0], $x))		
				{
				$i=$row1[0];
				$u=$x[$i];
				$query2  = "SELECT * FROM users WHERE user_id='$u'";
				$result2 = $conn->query($query2);
				$row2 = $result2->fetch_array(MYSQLI_NUM);

				echo "<div id='messages' style='padding: 2px;'>";
				echo "<img src='images/$row2[7]' width='30'  height='30' style='float: left;  border-radius: 30px'>";
				$str = substr($row1[3],0,20);
				echo "<span><a href='single_message.php?otherpersonid=$row2[0]&otherpersonname=$row2[1]&otherpersonimage=$row2[7]' style='text-decoration: none; color: black; margin-left:10px;'><b>$row2[1]:</b></a></span>";
				echo "<span style='margin-left:10px;'>$str...</span>";
				echo "<p style='text-align:right; color: #979797'>$row1[4]</p>";
				echo "</div>";
				}
				}
			?>	
			</div>
			<br>
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
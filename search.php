<?php
session_start();
include("includes/connection.php");
$query  = "SELECT * FROM users WHERE user_name LIKE '%".$_POST["search_string"]."%'";
$result = $conn->query($query);
$rows = $result->num_rows;
echo "<div style='margin-top: -10px;'>";
for ($j = 0 ; $j < $rows ; ++$j)
{
	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_NUM);
	echo "<p style='background-color: #cccccc; border-bottom: 1px solid lightblue; line-height: 2;  padding: 5px;'><a href='user_profile.php?profile_id=$row[0]' style='text-decoration: none; color: black;'>$row[1]</a></p>";
}
echo "</div>";
?>

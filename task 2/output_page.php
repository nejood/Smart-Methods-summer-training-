
<!DOCTYPE html>
<html>
<head>
	<title>Output Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color:#bbdef0;">

 <?php
 require_once('connection.php');
 $sql = "select button_letter from task2 ORDER BY Rid DESC LIMIT 1";
   $result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
	$letter = mysqli_fetch_row($result);
	echo "<center>";
	echo "<div style='color:#1d3557;font-size: 150px;'>" .$letter[0]. "</div>";
	echo "</center>";
	header("refresh: 2");

}
 ?>
</body>
</html>



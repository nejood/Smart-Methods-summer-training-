<?php
require_once('connection.php');

extract($_POST);
if(isset($_POST['submit'])){
	$q = "insert into task2 (button_letter) values ('f')";
	$que = mysqli_query($conn,$q);
}

?>
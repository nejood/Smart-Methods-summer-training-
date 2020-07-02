<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','smart_methods');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die('unable to connect');

?>
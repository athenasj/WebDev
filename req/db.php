<?php
$con=mysqli_connect("localhost","root","","photog");
if(!$con){
	die('Could not connect. Reason:'.mysqli_connect_error($con));
}

?>
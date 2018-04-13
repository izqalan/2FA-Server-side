<?php


	$con = mysqli_connect("localhost", "id3219967_root", "123456", "id3219967_twofa") or die(mysqli_error());
	// $db = mysqli_select_db($con,"2fa") or die(mysqli_error($con));
	if(!$con)
	{
		die(mysqli_error());
	}
	

?>
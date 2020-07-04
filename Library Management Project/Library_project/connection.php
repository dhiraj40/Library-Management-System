<!DOCTYPE html>
<html>
<body>
<?php
	$conn = new mysqli("localhost","root","","mylibrary");
	if($conn->connect_error){
		die("Connection failed".$conn->connect_error);
	}
	session_start();
?>
</body>
</html>
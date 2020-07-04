<?php
	include "navi.php";
	if(isset($_SESSION["login_user"])){
?>
<!DOCTYPE html>
<html>
<head>
	<style >
		nav .menu #stds{
			font-size: 25px;
			text-shadow: 1px 1px 2px black;
		}

		.st-nav{
			background:rgba(0,0,0,0.4);
			height:50px;
			display: flex;
			align-items:center;
			padding-left: 40%;
		}

		.st-nav a{
			width: 150px;
			text-decoration: none;
			color: white;
			font-size: 18px;
			text-align: center;
			border: 0px solid grey;
			height: 40px;
			margin-top: 10px;
			padding-top: 10px;
			border-radius: 30px 30px 0px 0px;
		}

		#apr-nav{
			margin-left: -20px;
		}

	</style>
	<title></title>
</head>
<body>
	<!-- ************* NAVIGATION ************** -->
	<div class = "st-nav">
		<a href="students-list.php" id="std-nav">Students</a>
		<a href="approve-list.php" id="apr-nav">Approve</a>
	</div>
</html>
<?php } ?>
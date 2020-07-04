<?php
	include "connection.php";
if (isset($_SESSION["login_user"])){
	$user = $_SESSION["login_user"];
?>
<!DOCTYPE html>
<html>
<head>
	<style>
		*{
		  margin: 0;
		  padding: 0;
		  box-sizing: border-box;
		}
		nav{
			height: 100px;
			color: white; display: flex; justify-content: space-between;
			align-items:center;
			background: red;
		}
		.logo{
			padding-left: 20px;
		}
		.hide-Class{
			display: none;
		}
		.logo img{
			cursor: pointer;
			border: 4px solid white;
			border-radius: 30px;
			width: 40px;
			height:40px;
		}
		nav .menu{
		  width: 40%;
		  display: flex; 
		  justify-content: space-around;
		}

		nav .menu a{
		  width: 25%;
		  font-size: 18px;
		  text-decoration: none; color: white;
		  font-weight: bold;
		}
		.logobar{
			z-index: 1;
			top: 5%;
			left: 5%;
			position: fixed;
			padding: 10px;
			height: 65px;
			width: 150px;
			background: white;
			border: 0px solid black;
			box-shadow: 0px 0px 15px;
		}
		.logobar a{
			text-decoration: none;
			padding: 10px;
		}
		button{
			cursor: pointer;
		}
	</style>
	<title></title>
</head>
<body>
	<nav id='abc'>
		<div class="logo">
			<a onclick="toggleHideClass()" ><img src="image/p.jpg"></a>
			<h2>LMP</h2>
		</div>
		<div class="menu">
			<a href="books.php" id="book">Books</a>
			<a href="students-list.php" id="stds">Students</a>
			<a href="return.php" id="rtn">ReturnBooks</a>
		</div>
	</nav>
	<div class="logobar hide-Class" id="lbr">
		<a href="addAdmin.php">Add admin</a><br>
		<a href="students/logout.php">Log Out</a>
	</div>
<script type="text/javascript">
	function toggleHideClass(){
		var id=document.getElementById('lbr');
		id.classList.toggle('hide-Class');
	}
</script>
</body>
</html>
<?php }else{ ?>
	<script type="text/javascript">
		alert("Login First.");
		window.location = "index.php";
	</script>
<?php } ?>
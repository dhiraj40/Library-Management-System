<?php
	include "connection.php";
if (isset($_SESSION["login_user"])){
	$user = $_SESSION["login_user"];
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body{
			background: #ffc1c1;
		}
		.main{
			margin-top: 5vh;
			margin-left: 10%;
			width: 80%;
			height: 90vh;
			box-shadow: 0px 0px 15px;
		}
		.main #heading{
			padding-top: 20px;
		}
		.inpbox{
			position: relative;	
			margin-left: 25%;
			width: 600px;
			height: 35px;
			margin-top: 4%;
			margin-bottom: 4%;
		}
		.inpbox input{
			width: 100%;
			height: 100%;
			outline: none;
			border: 2px solid #02b281;
			border-radius: 15px;
			padding-left: 10px;
			background: rgba(0,0,0,0);
		}

		.inpbox span{
			position: absolute;
			top: 50%;
			left: 3%;
			pointer-events: none;
			transform: translateY(-50%);
			font-size: 20px;
			color: #643131;
		}

		.inpbox input:focus + span,.inpbox input:valid + span{
			top: 0;
			font-size: 16px;
			background: #ffc1c1;
		}
		button{
			width: 120px;
			height: 40px;
			border-radius: 50px;
			outline: none;
			cursor: pointer;
		}
	</style>
	<title></title>
</head>
<body>
	<div class="main">
		<center>
			<div id="heading"><h1>ADD ADMIN</h1></div>
		</center>
		<form action="addAdmin.php">
			<div class="inpbox">
				<input type="text" name="adm-regn-add" id="adm-regn-add"  required>
				<span>ID</span>
			</div>
			<div class="inpbox">
				<input type="text" name="adm-name-add" id="adm-name-add"  required>
				<span> Name </span>
			</div>
			<div class="inpbox">
				<input type="text" name="adm-mail-add" id="adm-mail-add"  required>
				<span>Email</span>
			</div>
			<div class="inpbox">
				<input type="text" name="adm-cont-add" id="adm-cont-add"  required>
				<span>Phone</span> 
			</div>
			<div class="inpbox">
				<input type="text" name="adm-pass-add" id="adm-pass-add"  required>
				<span>Password</span>
			</div>
				<center><button name="add-but">Add Student</button></center>
		</form>
	</div>
	<?php
		if(isset($_POST["add-but"])){
			$id = $_POST["adm-regn-add"];
			$name = $_POST["adm-name-add"];
			$mail = $_POST["adm-mail-add"];
			$phone = $_POST["adm-cont-add"];
			$pass = $_POST["adm-pass-add"];

			$res = $conn->query("select * from admin where id='$id'");
			if($res->num_rows > 0){
				echo "<script>alert('user already exists.')</script>";
			}else{
				$res = $conn->query("insert into admin values('$id','$name','$mail','$phone','$pass')");
				if($res){
					echo "<script>alert('New admin added.')</script>";
				}
			}
		}
	?>
</body>
</html>
<?php } ?>

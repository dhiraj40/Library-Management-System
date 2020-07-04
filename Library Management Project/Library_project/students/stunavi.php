<?php
	include "../connection.php";
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
			height: 10vh;
			color: white; display: flex; justify-content: space-between;
			align-items:center;
			background: #333;
		}
		.logo{
			padding-left: 20px;
		}
		.logo img{
			cursor: pointer;
			border: 1px solid white;
			border-radius: 30px;
			width: 40px;
			height:40px;
		}
		
		.logo span{
			position: absolute;
			padding: 10px;
			font-size: 22px;
		}

		.logout a{
			color: #9d9d9d;
			text-decoration: none;
			font-weight: 400;
			line-height: 1;
			margin-right: 50px;
			font-size: 20px;
		}

		.logout a:hover{
			color: white;
		}

		button,a{
			cursor: pointer;
		}
		#stud-info{
			z-index: 1;
			position: fixed;
			width: 100%;
			height: 90vh;
			color: #fff;
			background: #004528;
			padding-left: 35%;
			padding-top: 20px; 
			font-size: 18px;
		}
		#stud-info img{
			height: 200px;
			width: 200px;
			border-radius: 100px;
			margin-left: 120px;
			margin-bottom: 50px;
		}
		#stud-info a,#stud-info button{
			background: #fff;
			color: black;
			padding: 20px;
			padding-top: 8px;
			padding-bottom: 8px; 
			border-radius: 4px;
		}
		#stud-info a:hover{
			opacity: 0.8;
		}

		#edit-butt{
			margin-left: 60%;
			/*display: none;*/
		}
		.stud-info-show{
			display: none;
		}
		.info-table{
			border: 2px solid black;
			border-spacing: 0;
			border-collapse: collapse;
		}
		.info-table td{
			border: 2px solid black;
			padding: 10px;
		}

		#form-edit{
			display: none;
			padding-top: 21px;
		}
		#form-edit span{
			position: absolute;
			left: 42.8%;
			top: 6.1%;
			text-align: center;
			background: rgba(0,0,0,0.5);
			height: 200px;
			width: 200px;
			padding-top: 150px;
			border-radius: 100px;
			cursor: crosshair;
		}
		.info-table-edit{
			border: 2px solid black;
			border-spacing: 0;
			border-collapse: collapse;
			margin-bottom: 30px;
		}
		.info-table-edit td{
			border: 2px solid black;
		}
		.info-table-edit input{
			margin-top: 0px;
			width: 300px;
			padding: 10px;
			background: rgba(0,0,0,0);
			outline: none;
			border: 0px solid black;
			color: white;
			font-size: 18px;
			font-family: Times New Roman;
		}
		#form-edit #sublink{
			margin-left: 100px;
		}

		.inp-img{
			width: 300px;
			
		}

		.inp-img .show_hide_pass{
			 display: flex;
			 justify-content: space-between;
		}
		#form-show{
			/*display: none;*/
		}
	</style>
	<title></title>
</head>
<body>
<?php
if(isset($_SESSION["login_user"])){
	$user = $_SESSION["login_user"];
	$sql = "select * from students where id = '$user'";
	$res = $conn->query($sql);
	while($row = $res->fetch_assoc()){
		$pass = $row["password"];
		$tpass = '';
		$pic = $row["pp"];
		echo "<script>var upass = '$pass';</script>";
		for ($i=0; $i < strlen($pass) ; $i++) { 
			$tpass = $tpass.'*';
		}
?>
	<nav id='abc'>
		<div class="logo">
			<a onclick = "stud_info_show()"><img src="<?php echo $pic;?>"></a>
			<span><?php echo $row["name"]; ?></span>
		</div>
		<div class="logout">
			<a href="logout.php">LOGOUT</a>
		</div>
	</nav>
	<div id="stud-info" class="stud-info-show">
		<a id="edit-butt" onclick="editForm()">Edit</a>
		<div id="form-show">
			<img src="<?php echo $row["pp"];?>">
			<table class="info-table">
				<tr>
					<td>Name : </td>
					<td class="inp-img"><div id="name-show" class=""><?php echo $row["name"]; ?></div></td>
				</tr>
				<tr>
					<td>Registration no : </td>
					<td class="inp-img"><div id="regn-show" class=""><?php echo $user; ?></div></td>
				</tr>
				<tr>
					<td>Email : </td>
					<td class="inp-img"><div id="mail-show" class=""><?php echo $row["email"]; ?></div></td>
				</tr>
				<tr>
					<td>Phone no : </td>
					<td class="inp-img"><div id="phon-show" class=""><?php echo $row["phone"]; ?></div></td>
				</tr>
				<tr>
					<td>Password : </td>
					<td class="inp-img">
						<div class="show_hide_pass">
							<span id="pass-show"><?php echo $tpass; ?></span>
							<button onclick="show_pass()" id="show_pass">show</button>
							<button onclick="hide_pass()" id="hide_pass" style="display: none">hide</button>
						</div>
					</td>
				</tr>
			</table>
<?php	} ?>
		</div>
		<form action="books.php" id="form-edit" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file" style="display: none;" >
			<label for="file"><img src="<?php echo $pic;?>"><span>Add Photo</span></label>
			<table class="info-table-edit">
				<tr>
					<td style="padding: 10px;">Name : </td>
					<td><input type="text" name="st_name" id="name-input" required></td>
				</tr>
				<tr>
					<td style="padding: 10px;">Registration no :</td>
					<td>
						<!-- <input type="text" name="st_regn" id="regn-input" style="display: none;"> -->
						<div style="padding-left: 10px;"><?php echo "$user"; ?></div>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px;">Email : </td>
					<td><input type="text" name="st_mail" id="mail-input" required></td>
				</tr>
				<tr>
					<td style="padding: 10px;">Phone no : </td>
					<td><input type="text" name="st_phon" id="phon-input" required></td>
				</tr>
				<tr>
					<td style="padding: 10px;">Password : </td>
					<td><input type="text" name="st_pass" id="pass-input" required></td>
				</tr>
			</table>
			<div id="sublink">
				<button type="submit" name="save-edit">Save</button>
				<button >Cancel</button>
			</div>			
		</form>
		<?php
			if(isset($_POST["save-edit"])){
				$name = $_POST["st_name"];
				$mail = $_POST["st_mail"];
				$phon = $_POST["st_phon"];
				$pass = $_POST["st_pass"];
				if($_FILES["file"]["error"] == 0){
					move_uploaded_file($_FILES["file"]["tmp_name"],"uploaded/".$_FILES["file"]["name"]);
					$pic = "uploaded/".$_FILES["file"]["name"];
					echo "$pic";
					$res = $conn->query("update students set pp='$pic',name='$name',email='$mail',phone='$phon',password='$pass'where id='$user'");
				}else{
					$res = $conn->query("update students set name='$name',email='$mail',phone='$phon',password='$pass'where id='$user'");
				}
				
				if($res){
					?>
					<script type="text/javascript">
						alert("Saved Successfully.");
						window.location="books.php";
					</script>
					<?php
				}else{
					echo "<script>alert('Saved Successfully.');</script>";
				}
			}
		?>
	</div>
	<script type="text/javascript">
		/*function addEvents(ev){
			
		}*/

		function stud_info_show(){
			var id = document.getElementById('stud-info');
			id.classList.toggle('stud-info-show');
		}

		function show_pass(){
			document.getElementById('show_pass').style.display = 'none';
			document.getElementById('hide_pass').style.display = 'block';
			document.getElementById('pass-show').innerHTML = upass;
		}

		function hide_pass(){
			document.getElementById('show_pass').style.display = 'block';
			document.getElementById('hide_pass').style.display = 'none';
			var tpass = '';
			for(var i=0;i<upass.length;i++){
				tpass += "*";
			}
			document.getElementById('pass-show').innerHTML = tpass;
		}

		 function editForm(){
		 	document.getElementById('form-show').style.display='none';
		 	document.getElementById('edit-butt').style.display='none';
		 	document.getElementById('form-edit').style.display='block';
		 	document.getElementById('name-input').value = document.getElementById('name-show').innerHTML;
		 	/*document.getElementById('regn-input').value = document.getElementById('regn-show').innerHTML;*/
		 	document.getElementById('mail-input').value = document.getElementById('mail-show').innerHTML;
		 	document.getElementById('phon-input').value = document.getElementById('phon-show').innerHTML;
		 	document.getElementById('pass-input').value = upass;
		 }
		/*document.addEventListener('DOMContentLoaded',addEvents);*/
	</script>
<?php }else{ ?>
	<script type="text/javascript">
		alert("Login First.");
		window.location = "../index.php";
	</script>
<?php
}
?>
</body>
</html>

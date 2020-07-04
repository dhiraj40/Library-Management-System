<?php
	include "students.php";
	if(isset($_SESSION["login_user"])){
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/initialstyle.css">
	<style>		
		body{
			background: #ffc1c1;
		}
		#std-nav{
			background: #ffc1c1;
			color: black;
			border: 0px solid white;		
		}
		.std-detail{
			/*display: none;*/

			position: fixed;
			overflow: auto;
			z-index: 1;
			left:60%; top: 40%;
			background: #ffc1c1;
			width: 38%;
			height: 55%;
			margin-top: -20px;
			padding: 20px;
			border: 0px solid black;
			box-shadow: 0px 0px 5px black;
		}

		.std-detail button{
			margin-top: 20px;
		}
		.std-detail #cancelBut{
			width: 30px;
			border: 1px solid black;
			margin-left: 98%;
			margin-top: -200px;
		}

	</style>
	<title>Student List</title>
</head>
<body>
	
<!-- ************* STUDENTS **************** -->
	<div class="srchbar">
		<button onclick="addStud()">Add Students</button>
		<div class="search">
			<form action="students-list.php" method="post">
				<input type="text" name="srchbox" id="srch_id" placeholder="search..." >
			</form>	
		</div>
	</div>
	<script type="text/javascript">
		function addStud(){
			document.getElementById('std-detail').style.display = 'none';
			document.getElementById('std-detail-add').style.display='block'
		}
	</script>

	<hr style="height: 5px;background-color: white;">
	
	<div id="contents">
		<h2 id="srchres"></h2>
		<table>
			<div id="tab_head">
				<thead>
					<th class="imgClass"></th>
					<th class="regnClass">Reg no.</th>
					<th class="nameClass">Name</th>
					<th class="mailClass">Email</th>
					<th class="contClass">Phone</th>
					<th></th>
				</thead>
			</div>
			<tbody>
			<?php
				function resultprint($con,$sqlquery){
					$count = 0;
					$res = $con->query($sqlquery);
					while (($row = mysqli_fetch_assoc($res))) {
						/*var_dump($row);
						echo "<br>";*/
						$count += 1;
						$sid = $row["id"];
						$ppic = $row["pp"];
						$pp_id = 'pp_'.$count;
						$stud_id = 'stud_'.$count;
						$name_id = 'name_'.$count;
						$mail_id = 'mail_'.$count;
						$cont_id = 'cont_'.$count;
						$butn_id = 'butn_'.$count;
						echo "<tr>";
						echo "<td id='$pp_id' class='ppClass' value='$ppic'><img src='students/".$ppic."' ></td>";
						echo "<td id='$stud_id' class='regnClass'>".$sid."</td>";
						echo "<td id='$name_id' class='nameClass'>".$row["name"]."</td>";
						echo "<td id='$mail_id' class='mailClass'>".$row["email"]."</td>";
						echo "<td id='$cont_id' class='contClass'>".$row["phone"]."</td>";
						echo "<td><button class='button-list' id='$butn_id' value='$count'>Modify</button></td>";
						echo "</tr>";
					}
					return $count;
				}

				function ResultSql($conn){
					if(isset($_POST["srchbox"])){
						$na = $_POST["srchbox"];
						if($na == ""){
							$sql  = "select * from students";
							$count = resultprint($conn,$sql);
						}else{
							echo "<script>document.getElementById('srch_id').value = '$na'</script>";
							echo "<script>document.getElementById('srchres').innerHTML = 'Search results for ".$na." '</script>";
							$sql  = "select * from students where id like '%$na%' or name like '%$na%' or email like '%$na%' or phone like '%$na%'";
							$count = resultprint($conn,$sql);
						}
					}else{
						$sql  = "select * from students";
						$count = resultprint($conn,$sql);
					}
					return $count;
				}
				$count = ResultSql($conn);
				echo "<script> var count =".$count." </script>";
			?>
			</tbody>
		</table>
	</div>
	<div class=std-detail id=std-detail>
		<button id="cancelBut" onclick="document.getElementById('std-detail').style.display='none'">X</button>
		<center>
			<h2>STUDENT DETAIL</h2>
		</center>
		<form action="students-list.php" method="post">
			<div class="inpbox">
				<input type="text" name="st-regn" id="st-regn" required>
				<span>RegNo.</span>
			</div>
			<div class="inpbox">
				<input type="text" name="st-name" id="st-name" required>
				<span> Name </span>
			</div>
			<div class="inpbox">
				<input type="text" name="st-mail" id="st-mail" required>
				<span>Email</span> 
			</div>
			<div class="inpbox">
				<input type="text" name="st-cont" id="st-cont" required>
				<span>Phone</span> 
			</div>
			<center>
				<button name="mod-but">Modify</button>
				<button name="del-but">Delete</button>
			</center>	
		</form>
	</div>

	<!-- ***********add student********************* -->
	<div class=std-detail id=std-detail-add>
		<button id="cancelBut" onclick="document.getElementById('std-detail-add').style.display='none'">X</button>
		<center><h2>STUDENT DETAIL</h2></center>
		<form action="students-list.php" method="post">
			<div class="inpbox">
				<input type="text" name="st-regn-add" id="st-regn-add"  required>
				<span>RegNo.</span>
			</div>
			<div class="inpbox">
				<input type="text" name="st-name-add" id="st-name-add"  required>
				<span> Name </span>
			</div>
			<div class="inpbox">
				<input type="text" name="st-mail-add" id="st-mail-add"  required>
				<span>Email</span>
			</div>
			<div class="inpbox">
				<input type="text" name="st-cont-add" id="st-cont-add"  required>
				<span>Phone</span> 
			</div>
			<div class="inpbox">
				<input type="text" name="st-pass-add" id="st-pass-add"  required>
				<span>Password</span>
			</div>
			<center>
				<button name="add-but">Add Student</button>
			</center>	
		</form>
	</div>
	<?php
		if(isset($_POST["add-but"])){
			$sid = $_POST["st-regn-add"];
			$snm = $_POST["st-name-add"];
			$sml = $_POST["st-mail-add"];
			$spn = $_POST["st-cont-add"];
			$pas = $_POST["st-pass-add"];
			$res = $conn->query("select * from students where id='$sid'");
			if(($res->num_rows)!=0){
				echo "<script>alert('User Already Exists.');</script>";
			}else{
				$res = $conn->query("insert into students(id, name, email, phone, password) values('$sid','$snm','$sml','$spn','$pas')");
				if($res){
					echo "<script>alert('User $sid $snm added');</script>";
				}else{
					die('Connection Error');
				}
			}
		}
		if(isset($_POST["mod-but"])){
			$sid = $_POST["st-regn"];
			$snm = $_POST["st-name"];
			$sml = $_POST["st-mail"];
			$spn = $_POST["st-cont"];

			$sql = "update students set name='$snm', email='$sml', phone='$spn' where id='$sid'";
			$res = $conn->query($sql);
			if($res){
				echo "<script> alert('successfully Modified.');</script>";
			}
		}
		if(isset($_POST["del-but"])){
			$sid = $_POST["st-regn"];
			$snm = $_POST["st-name"];
			$sml = $_POST["st-mail"];
			$spn = $_POST["st-cont"];

			$sql = "delete from students where id='$sid'";
			$res = $conn->query($sql);
			if($res){
				echo "<script> alert('successfully Deleted.'); </script>";
			}
		}
	?>
	<script>
		let partyStarted = function(){
			let lis = document.querySelectorAll('.button-list');
			lis.forEach(li =>{
				li.addEventListener('click',onClick);
			})
		}

		let onClick = function(ev){
			document.getElementById('std-detail-add').style.display='none';
			let val = ev.currentTarget.getAttribute('value');
			document.getElementById('st-regn').value = document.getElementById("stud_"+val).innerHTML;
			document.getElementById('st-name').value = document.getElementById("name_"+val).innerHTML;
			document.getElementById('st-mail').value = document.getElementById("mail_"+val).innerHTML;
			document.getElementById('st-cont').value = document.getElementById("cont_"+val).innerHTML;
			document.getElementById('std-detail').style.display='block';
		}
		document.addEventListener('DOMContentLoaded',partyStarted);
	</script>
</body>
</html>
<?php } ?>
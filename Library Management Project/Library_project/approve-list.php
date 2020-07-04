<?php
	include "students.php";
	if(isset($_SESSION["login_user"])){
?>
<!DOCTYPE html>
<html>
<head>
	<style>
		body{
			background: #ffc1c1;
		}
		#apr-nav{
			background: #ffc1c1;
			color: black;
			border: 0px solid white;
		}

		.approval-list{
			margin-top: 10px; 
			margin-left: 40px;
			border: 1px solid black;
			width: 40%;
			padding: 20px;
			border-radius: 30px;
			box-shadow: 0px 0px 5px black;
		}
		
		.approval-list-item{	
			display: flex;
			/*margin-bottom: 20px;*/
		}

		.approval-list-item button{
			outline: none;
			width: 100px;
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 10px;
			margin-left: 350px;
			height: 25px;
			/*margin-right: 1%;*/ 
		}

		.approval-list-item #ex-con{
			/*display: none;*/
			cursor: pointer;
			margin-left: 2%;
			font-size: 20px;
			width: 30px;
			color: red;
		}
		.approval-list-item .contract{
			display: none;

		}
		.approval-list hr{
			box-shadow: 0px 0px 2px black;
			margin-bottom: 10px;
		}
		.st-list-detail{
			background: #e2a5a5;
			width: 100%;
			height: 100%;
			z-index: -1;
			display: none;

		}
		.st-list-detail hr{
			margin-top: 20px;	
			color: black;
		}

		.confirm-popup{
			display: none;
			z-index: 1;
			position: fixed;

			left: 25%;
			top: 40%;
			background: rgba(190,95,95,1);
			border: 10px solid tomato;
			width: 750px;
			padding: 20px;
			box-shadow: 0px 0px 10px black;
		}

		.confirm-popup button{
			cursor: pointer;
			outline: none;
			margin-top: 10px;
			border-radius: 5px 5px;
			width: 100px;
			height: 30px;
		}
		/*#confirm-popup{	
			padding-top: 6%;
			width: 700px;
			height: 130px;
			border: 0px solid black;
			background: #fff;
			box-shadow: 0px 0px 5px black;
		}
		#popup-cancel{
			border: 0px solid black;
			background: red;
			border-radius: 10px;
			text-align:center;
			color: white;
			width: 18px;
			cursor: pointer;
			margin-left: 99%;
			box-shadow: 0px 0px 10px red;
		}
		#confirm-popup h2{
			padding-bottom: 10px;
		}

		#confirm-popup button{
			margin-top: 10px;
			width:50px;

		}*/

		/*#subyes{
			outline: none;
			color: white;
			background: red;
		}*/

		.cncl-appr{
			padding: 5px;
			outline: none;
			background: red;
			border-radius: 15px;
			color: white;

		}
	</style>
	<title>Approve List</title>
</head>
<body>	
	<?php
		$sql = "select * from appr_req";
		$res = $conn->query($sql);
		$count = 0;
		while ($row=mysqli_fetch_assoc($res)){
			$count = $count+1;
			$sid = $row["sid"];
			$stud_id = 'stud_'.$count;
			$app_but = 'apr-butt-'.$count;
			$name_id = 'name_'.$count;
			$hid_id = 'st-list-detail-'.$count;
			$exid = 'expand_'.$count;
			$conid = 'contract_'.$count;
			echo (
				"<div class='approval-list'>"."<div class='approval-list-item'>"."<h3 id='$stud_id'> $sid </h3>".
				"<div>"."<button id='$app_but' class='apr-butt' value='$sid'>Approve</button>"."</div>".
				"<div id='ex-con'><h3 id='$exid' class='expand' value='$count' >+</h3><h3 id='$conid' class='contract' value='$count'>&#8212;</h3></div></div>".
				"<div class='st-list-detail' id='$hid_id'><hr>".
				"<table><tr>".
				"<td>Name :</td><td>".$row["name"]."</td></tr>".
				"<tr><td>Email :</td><td>".$row["email"]."</td></tr>".
				"<tr><td>Phone :</td><td>".$row["phone"]."</td></tr></table>".
				"<center><button class='cncl-appr' value='$sid'>Cancel Approval</button></center>".
				"</div></div>"
			);
		}
	?>

	<div id = "popUp" class="confirm-popup">
		<center>
			<form action="approve-list.php" method="post">
				<input type="text" name="regno" id="regno-id" style="display: none;">
				<h2>Are you sure?</h2>
				<button type="submit" name="subyes" id="subyes">Yes</button>
				<button onclick="document.getElementById('popUp').style.display='none'">No</button>
			</form>
		</center>

		<?php
			if(isset($_POST["subyes"])){
				$nm = $_POST["regno"];
				$res = $conn->query("select * from appr_req where sid = '$nm'");
				while ($row = mysqli_fetch_assoc($res)) {
					$sql = "insert into students(id, name, email, phone, password) values('".$row["sid"]."','".$row["name"]."','".$row["email"]."','".$row["phone"]."','".$row["password"]."')";
					$res = $conn->query($sql);
					if($res){
						$res = $conn->query("delete from appr_req where sid = '$nm'");
						if($res){
							echo "<script>alert('$nm approved Successfully.');</script>";
						}
					}
				}
			}
		?>
	</div>

	<!-- *****************cancel approval********************* -->

	<div id = "popUpCan" class="confirm-popup">
		<center>
			<form action="approve-list.php" method="post">
				<input type="text" name="regnoCan" id="regno-id-can" style="display: none;">
				<h2>Are you sure?</h2>
				<button type="submit" name="subyesCan" id="subyes">Yes</button>
				<button onclick="document.getElementById('popUpCan').style.display='none'">No</button>
			</form>
		</center>
		<?php
			if(isset($_POST["subyesCan"])){
				$nm = $_POST["regnoCan"];
				$res = $conn->query("delete from appr_req where id='$nm'");
				if($res){
					echo "<script>alert('Approval of $nm deleted successfully.');</script>";
				}
			}
		?>
	</div>

	<script>
		let addEventOnExCon = function(){
			let exlis = document.querySelectorAll('.expand');
			exlis.forEach(li=>{
				li.addEventListener('click',expandList);
			});
			let conlis = document.querySelectorAll('.contract');
			conlis.forEach(li=>{
				li.addEventListener('click',contractList);
			});

			let aprlis = document.querySelectorAll('.apr-butt');
			aprlis.forEach(li=>{
				li.addEventListener('click',confirmPopUp);
			});

			let canlis = document.querySelectorAll('.cncl-appr');
			canlis.forEach(li=>{
				li.addEventListener('click',canPopUp);
			});
		}

		expandList = function(event){
			var val = event.target.getAttribute('value');
			event.target.style.display = 'none';
			document.getElementById('contract_'+val).style.display = "block";
			document.getElementById('st-list-detail-'+val).style.display = 'block';
			/*document.getElementById('.approval-list-item').style.margin.bottom = '20px';*/
			/*document.getElementById('').style.display = */
		}
		contractList = function(event){
			var val = event.target.getAttribute('value');
			event.target.style.display = 'none';
			document.getElementById('expand_'+val).style.display = "block";
			document.getElementById('st-list-detail-'+val).style.display = "none";
			/*document.getElementById('.approval-list-item').style.margin.bottom = '0px';*/
			/*document.getElementById('').style.display = */
		}

		confirmPopUp = function(event){
			var reg = event.target.getAttribute('value');
			document.getElementById('regno-id').value = reg;
			document.getElementById('popUp').style.display = 'block';
		}

		canPopUp = function(event){
			document.getElementById('regno-id-can').value = event.target.getAttribute('value');
			document.getElementById('popUpCan').style.display = 'block';
		}
		document.addEventListener('DOMContentLoaded',addEventOnExCon);
	</script>
</body>
</body>
</html>
<?php } ?>
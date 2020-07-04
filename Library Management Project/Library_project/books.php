<?php
	include "navi.php";
	if(isset($_SESSION["login_user"])){
?>
<!DOCTYPE html>
<html>
<head>
	<style >
		body{
			background: #ffc1c1;
		}
		nav .menu #book{
			font-size: 25px;
			text-shadow: 1px 1px 2px black;
		}
		.srchbar{
			margin: 20px;
			padding: 20px;
			box-shadow: 0px 0px 10px black;
		}
		.operation button{
			outline: none;
			border-radius: 5px 5px;
			width: 100px;
			height: 30px;
		}
		.srchbar form{
			margin-top: -30px;
			margin-left: 75%;
		}
		.srchbar #srch_id{
			width: 250px;
			height: 30px;
			border-radius: 10px 10px; 
			outline: none;
		}
		#contents{
			box-shadow: 0px 0px 10px black;
			margin: 20px;
			padding: 20px;
		}
		table{
			margin: 10px;
			margin-left: 110px;
		}
		table .issnClass, .quanClass{
			text-align: center;
			width:100px;
		}
		table .nameClass, .authClass, .deptClass{
			text-align: left;
			width:250px;
		}
		table th{
			height: 40px;
			
		}
		table tr{
			box-shadow: 0px 0px 5px black;

		}
		table td{
			height: 30px;
			padding: 15px;
		}

		/******************Hidden World***********************/

		.addbook,.issuebook,.modifybook{
			display: none;	
			position: fixed;
			overflow: auto;
			z-index: 1;
			left: 0;
			top: 0;
			/*border: 2px solid black;*/
			background: #fff;
			border-radius: 25px;
			box-shadow: 0px 0px 100px black;
			
		}
		.addbook{
			/*display: none;*/
			margin-left: 25%;
			margin-top: 8%;
			width: 570px;
			height: 75%;
			padding: 50px;
			
		}
		.addbook h2{
			color: white;
			font-size: 28px;
			text-shadow: 1px 1px 6px black;
			font-weight: bold;
		}
		.addbook input[type='text'],.issuebook input[type='text'],.modifybook input[type='text']{
			outline: none;
			width: 400px;
			margin: 10px;
			margin-left: 30px;
			padding: 10px;
			border-radius: 10px;
		}
		input[type='text']:focus{
			opacity: 0.8;
		}
		.addbook button{
			margin:15px;
			outline: none;
			border-radius: 5px 5px;
			width: 100px;
			height: 30px;
		}
		.addbook #addbook_but{
			margin-left: 190px;
		}

		/****issue Book****/
		button,input[type="checkbox"]{
			cursor: pointer;
		}
		.issuebook{
			height: 450px;
			width:700px;
			margin: 20%;
			margin-top: 100px; 
		}
		button{
			outline: none;
			border-radius: 5px 5px;
			width: 100px;
			height: 30px;
		}

		#IssuedBookDetail{
			margin-top: 10px; 
			color: white;
			border:2px solid green;
			background: green;
			width: 40%;
			padding: 40px;
		}


		/****modify Book****/
		.modifybook{
			/*display: block;*/
			padding: 80px;
			margin-left: 400px;
			margin-top: 80px;
		}

		.button-list{
			background-color: white;
		}

		/****CheckBox******/
		.chekClass{
			position: relative;
			outline: none;
			/*-moz-appearance: none;*/
			-webkit-appearance:none;
			background: #9d9d9d;
			height: 30px;
			width: 60px;
			border: 5px solid #9d9d9d;
			transition: 1s;
			border-radius: 100px;
		}
		.chekClass:checked{
			border: 5px solid #1f9bf7;
			background: #1f9bf7;
		}
		.chekClass:before{
			content: '';
			position: absolute;
			left: 0;
			width: 50%;
			height: 100%;
			background: white;
			border-radius: 100px;
			transition: 1s;
		}
		.chekClass:checked:before{
			left: 50%;
		}

		/**********Pop Up***************/

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
	</style>
	<title>Books</title>
</head>
<body>

	<div class="srchbar">
		<div class="operation">
			<button onclick="document.getElementById('addbook_id').style.display='block'">Add Books</button>
			<button onclick="modifybook_func()">Modify</button>
			<button onclick="deleteBook_func()">Delete</button>
		</div>
		<div class="search">
			<form action="books.php" method="post">
				<input type="text" name="srchbox" id="srch_id" placeholder="search..." >
			</form>	
		</div>
	</div>

	<hr style="height: 5px;background-color: white;">
	
	<div id="contents">
		<h2 id="srchres"></h2>
		<table>
			<div id="tab_head">
			<thead >
				<th></th>
				<th class="issnClass">ISSN</th>
				<th class="nameClass">Book name</th>
				<th class="authClass">Author name</th>
				<th class="editClass">Edition</th>
				<th class="quanClass">Quantity</th>
				<th class="deptClass">Department</th>
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
						$bid = $row["bid"];
						$chek_id = 'chek_'.$count;
						$issn_id = 'issn_'.$count;
						$name_id = 'name_'.$count;
						$auth_id = 'auth_'.$count;
						$edit_id = 'edit_'.$count;
						$quan_id = 'quan_'.$count;
						$dept_id = 'dept_'.$count;
						$butn_id = 'butn_'.$count;
						echo "<tr>";
						echo "<td><input type='checkbox' name='$chek_id' id='$chek_id' value='$bid' class='chekClass'></td>";
						echo "<td id='$issn_id' class='issnClass'>".$bid."</td>";
						echo "<td id='$name_id' class='nameClass'>".$row["name"]."</td>";
						echo "<td id='$auth_id' class='authClass'>".$row["authors"]."</td>";
						echo "<td id='$edit_id' class='editClass'>".$row["edition"]."</td>";
						echo "<td id='$quan_id' class='quanClass'>".$row["quantity"]."</td>";
						echo "<td id='$dept_id' class='deptClass'>".$row["department"]."</td>";
						echo "<td><button class='button-list' id='$butn_id' value='$count'>ISSUE</button></td>";
						echo "</tr>";
					}
					return $count;
				}
				
				function ResultSql($conn){
					if(isset($_POST["srchbox"])){
						$na = $_POST["srchbox"];
						if($na == ""){
							$sql  = "select * from books";
							$count = resultprint($conn,$sql);
						}else{
							echo "<script>document.getElementById('srch_id').value = '$na'</script>";
							echo "<script>document.getElementById('srchres').innerHTML = 'Search results for ".$na." '</script>";
							$sql  = "select * from books where bid like '%$na%' or name like '%$na%' or authors like '%$na%' or edition like '%$na%' or department like '%$na%'";
							$count = resultprint($conn,$sql);
						}
					}else{
						$sql  = "select * from books";
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


	<!-- *********************
		***************************hidden world****************************
													*********************** -->



	<!-- <div class="addbook_body" id="addbook_id"> -->
	<div class="addbook" id="addbook_id">
		<h2 align="center">ADD BOOKS</h2>
		<form action="books.php" method="post">
			<input type="text" name="issn" id="issn_inp" placeholder="ISSN" required>
			<input type="text" name="name" id="name_inp" placeholder="Name" required>
			<input type="text" name="auth" id="auth_inp" placeholder="Author" required>
			<input type="text" name="edit" id="edit_inp" placeholder="Edition" required>
			<input type="text" name="quan" id="quan_inp" placeholder="Quantity" required>
			<input type="text" name="dept" id="dept_inp" placeholder="Department" required>
			<button type="submit" name="addbook" value="submit" id="addbook_but">AddBook</button>
			<button id="cncl_but" onclick="document.getElementById('addbook_id').style.display='none'">Cancel</button>
		</form>
		<?php
			if(isset($_POST["addbook"])){
				$iss = $_POST["issn"];
				$nam = $_POST["name"];
				$aut = $_POST["auth"];
				$edi = $_POST["edit"];
				$qua = $_POST["quan"];		
				$dep = $_POST["dept"];	
				$result = $conn->query("select * from books where bid = '$iss'");
				if(($result->num_rows)==0){
					$sql = "insert into books values('$iss','$nam','$aut','$edi',$qua,'$dep',0)";
					$res = mysqli_query($conn,$sql);
					if($res){
						echo "<script>alert('Book inserted Sucessfully.');</script>";
						echo "<script>document.getElementById('addbook_id').style.display='block'</script>";	
					}
					else{
						echo "<script>alert('Connection Error. Please check your connection or sqlquery.');</script>";
						echo "<script>document.getElementById('addbook_id').style.display='block'</script>";
					}
				}else{
					echo "<script>alert('Book id already exists.');</script>";
				}		
				
			}
		?>

	</div>
	<!-- </div> -->
	<div class="issuebook" id="issuebook">
	<center>
		<div id="IssuedBookDetail"></div>
		<form action="books.php" method="post">
			<input type="text" name="sid" placeholder="Enter RegNo..." required><br>
			<input type="text" name="bid" id="bid" style="display: none;" required><br>	
			<button type='submit' name='isu_but'>IssueBook</button>
			<button onclick="document.getElementById('issuebook').style.display='none'">Cancel</button>
		</form>
	</center>
	<?php 
		if(isset($_POST["isu_but"])){
			$bid = $_POST["bid"];
			$sid = $_POST["sid"];
			$isu_date = Date('Y-m-d');
			$d1 = strtotime($isu_date);
			$d1 += (86400*15);
			$ret_date = Date('Y-m-d',$d1);
			/*echo "$isu_date <br> $ret_date";*/
			$res_stdn = $conn->query("select * from students where id='$sid'");
			if(($res_stdn->num_rows)==1){
				$res = $conn->query("Insert into issue_book value('$sid','$bid','$isu_date','$ret_date')");
				$result = $conn->query("update books set quantity = (quantity-1) where bid = '$bid'");
				$res = $conn->query("update books set checkout = (checkout+1) where bid = '$bid'");
				echo "<script>alert('Book issued Sucessfully.');</script>";
				?>
				<script type="text/javascript">
					window.location = "books.php";
				</script>
				<?php
			}
			else{
				echo "<script>alert('Invalid User.');</script>";
			}
			
		}
	?>
	</div>


	<script type="text/javascript">
		let partyStarted = function(){
			let lis = document.querySelectorAll('.button-list');
			lis.forEach(li =>{
				li.addEventListener('click',onClick);
			});

			for (var i = 1; i <= count; i++) {
				var n = document.getElementById('quan_'+i).innerHTML;
				if(n==0){
					document.getElementById('butn_'+i).disabled = true;
				}
			}
		}

		let onClick = function(ev){
			let val = ev.currentTarget.getAttribute('value');
			var id = document.getElementById("issn_"+val).innerHTML;
			var nme = document.getElementById("name_"+val).innerHTML;
			var atn = document.getElementById("auth_"+val).innerHTML;
			var edn = document.getElementById("edit_"+val).innerHTML;
			var dpt = document.getElementById("dept_"+val).innerHTML;
			var str = id+"<br><br><h2>"+nme+"</h2><br><br>"+atn+"<br><br>"+edn+" Edition<br><br>"+dpt+"<br>";
			document.getElementById('bid').value = id;
			document.getElementById('IssuedBookDetail').innerHTML = str;
			document.getElementById('issuebook').style.display='block';
		}
		document.addEventListener('DOMContentLoaded',partyStarted);
	</script>

	<!-- ****************MODIFY BOOKS******************* -->

	<div class="modifybook" id="modifybook_id">
		<center>
			<h3>ISSN: <span id="isname"></span></h3>
			<form action="books.php" method="post">
				<input type="text" name="bisname" id="modiname" style="display: none;">
				<input type="text" name="bname" id="modbname" placeholder="Enter Book name..." required><br>
				<input type="text" name="aname" id="modaname" placeholder="Enter Author name..." required><br>
				<input type="text" name="edition" id="edition" placeholder="Enter Edition..." required><br>
				<input type="text" name="depart" id="depart"  placeholder="Enter Department..." required><br>
				<input type="text" name="quanti" id="quanti"  placeholder="Enter Quantity..." required><br>
				<button type="submit" value="submit" name='mod_but'>ModifyBook</button>
				<button onclick="document.getElementById('modifybook').style.display='none'">Cancel</button>	
			</form>	
		</center>
		<?php
			if(isset($_POST["mod_but"])){
				$bid = $_POST["bisname"];
				$nam = $_POST["bname"];
				$anm = $_POST["aname"];
				$edt = $_POST["edition"];
				$dpt = $_POST["depart"];
				$qnt = $_POST["quanti"];
				$sql = "update books set name='".$nam."', authors='".$anm."', edition='".$edt."', department='".$dpt."', quantity=".$qnt." where bid='".$bid."'";
				$res = mysqli_query($conn,$sql);
				echo "$sql";
				if ($res) {
					echo "<script>alert('Book Updated Sucessfully.')</script>";
					?>
					<script type="text/javascript">
						window.location = "books.php";
					</script>
					<?php
				}else{
					echo "<script>alert('Error occured.')</script>";
				}
			}
		?>	
	</div>

	<script>
		function modifybook_func(){
			var i;
			var temp = 0;
			var temp_id;
			for(i=1;i<=count;i++){
				if(temp<2){
					var checkid = "chek_"+i;
					if(document.getElementById(checkid).checked){
						temp+=1;
						temp_id = i;
					}
				}else{
					alert("Please select only one to modify.");
					break;
				}
			}
			if(temp==0){
				alert("Please select one item to modify.");
			}else if(temp==1){
				document.getElementById("isname").innerHTML += document.getElementById("issn_"+temp_id).innerHTML;
				document.getElementById("modiname").value = document.getElementById("issn_"+temp_id).innerHTML
				document.getElementById("modbname").value = document.getElementById("name_"+temp_id).innerHTML;
				document.getElementById("modaname").value = document.getElementById("auth_"+temp_id).innerHTML;
				document.getElementById("edition").value = document.getElementById("edit_"+temp_id).innerHTML;
				document.getElementById("depart").value = document.getElementById("dept_"+temp_id).innerHTML;
				document.getElementById("quanti").value = document.getElementById("quan_"+temp_id).innerHTML;
				document.getElementById('modifybook_id').style.display='block';
			}
			/**/
		}
	</script>

	<!-- ************DELETE BOOKS ************** -->

	<div id = "popUp" class="confirm-popup">
		<center>
			<form action="books.php" method="post">
				<input type="text" name="book-del" id="book-del-id" style="display: none;">
				<h2>Are you sure?</h2>
				<button type="submit" name="subyes" id="subyes">Yes</button>
				<button onclick="document.getElementById('popUp').style.display='none'">No</button>
			</form>
		</center>
		<?php
			if(isset($_POST["subyes"])){
				$ids = $_POST["book-del"];
				$issns = explode(' ',$ids);
				foreach ($issns as $val) {
					$res = $conn->query("delete from books where bid='$val'");
					if($res){
						echo "<script>alert('Book with issn $val is deleted.');</script>";
						?>
						<script type="text/javascript">
							window.location = "books.php";
						</script>
						<?php
					}else{
						die("<script>alert('Connection Error. $val not deleted.');</script>");
					}
				}
			}
		?>
	</div>
	<script>
		function deleteBook_func(){
			var i;
			var ids = '';
			var temp = 0;
			for(i=1;i<=count;i++){
				var checkid = "chek_"+i;
				var id = document.getElementById(checkid);
				if(id.checked){
					ids = ids + (id.value) + ' ';
					temp+=1;
				}
			}
			if(temp==0){
				alert('select at least one item');

			}else{
				document.getElementById('book-del-id').value = ids;
				document.getElementById('popUp').style.display = 'block';
			}
		}
	</script>
</body>
</html> 
<?php
}
?>
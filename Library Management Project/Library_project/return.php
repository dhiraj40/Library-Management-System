<?php
	include "navi.php";
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
		nav .menu #rtn{
			font-size: 25px;
			text-shadow: 1px 1px 2px black;
		}

		#contents{
			width: 60%;
		}

		#srch_id{
			margin-top: 25px;
		}

		.bknmClass{
			width: 300px;
			text-align: left;
		}

		#confirmPop{
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
		table .trClass{
			padding: 20px;
		}
		table button{
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
	<title>Book return</title>
</head>
<body>
	<div class="srchbar">
		<form action="return.php" method="post">
			<input type="text" name="srchbox" id="srch_id" placeholder="search..." >
		</form>	
	</div>

	<hr style="height: 5px;background-color: white;">
	
	<div id="contents">
		<h2 id="srchres"></h2>
		<table cellpadding="10">
			<div id="tab_head">
				<thead>
					<th class="regnClass">Reg no.</th>
					<th class="bookClass">BookId</th>
					<th class="bknmClass">BookName</th>
					<th class="issuClass">IssueDate</th>
					<th class="retnClass">ReturnDate</th>
					<th class="fineClass">Fine</th>
					<th></th>
				</thead>
			</div>
			<tbody>
			<?php
				function fineCalc($date1,$date2){
					$d1 = strtotime($date1);
					$d2 = strtotime($date2);
					$diff = (($d2 - $d1)/86400)-1;
					if($diff > 0){
						$fine = $diff*2;
					}
					else{
						$fine = 0;
					}
					return $fine;
				}

				function resultprint($con,$sqlquery){
					$count = 0;
					$res = $con->query($sqlquery);
					while (($row = mysqli_fetch_assoc($res))) {
						$sid = $row["sid"];
						
						$count += 1;
						$retndate = $row["return"];
						$today = Date('Y-m-d');
						$fine = fineCalc($retndate,$today);
						$regn_id = 'regn_'.$count;
						$bkid_id = 'bkid_'.$count;
						$butn_id = 'butn_'.$count;
						$fine_id = 'fine_'.$count;
						echo "<tr class='trClass'>";
						echo "<td id='$regn_id' class='regnClass'>".$sid."</td>";
						echo "<td id='$bkid_id' class='bookClass'>".$row["bid"]."</td>";
						echo "<td class='bknmClass'>".$row["name"]."</td>";
						echo "<td class='issuClass'>".$row["issue"]."</td>";
						echo "<td class='retnClass'>".$retndate."</td>";
						echo "<td class='fineClass' id='$fine_id'>".$fine."</td>";
						echo "<td><button class='button-list' id='$butn_id' value='$count'>Return</button></td>";
						echo "</tr>";
					}
					return $count;
				}

				function ResultSql($conn){
					if(isset($_POST["srchbox"])){
						$na = $_POST["srchbox"];
						if($na == ""){
							$sql  = "SELECT * FROM books JOIN issue_book HAVING books.bid=issue_book.bid";
							$count = resultprint($conn,$sql);
						}else{
							echo "<script>document.getElementById('srch_id').value = '$na'</script>";
							echo "<script>document.getElementById('srchres').innerHTML = 'Search results for ".$na." '</script>";
							$sql  = "SELECT * FROM books JOIN issue_book on books.bid=issue_book.bid WHERE issue_book.sid LIKE '%$na%' or books.name LIKE '%$na%' OR books.bid LIKE '%$na%'";
							$count = resultprint($conn,$sql);
						}
					}else{
						$sql  = "SELECT * FROM books JOIN issue_book HAVING books.bid=issue_book.bid";
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

	<div id="confirmPop">
		<center>
		<form action="return.php" method="post">
			<input type="text" name="regnam" id="regnam" style="display: none;">
			<input type="text" name="bknam" id="bknam" style="display: none;">
			<input type="text" name="bkfine" id="bkfine" style="display: none;">
			<h2>Are you Sure?</h2><br>
			<button id="yes" name="yes">yes</button>
			<button id="no" onclick="document.getElementById('confirmPop').style.display='none'">no</button>
		</form>
		</center>
		<?php
			if(isset($_POST["yes"])){
				$regnm = $_POST["regnam"];
				$bknam = $_POST["bknam"];
				$fine = $_POST["bkfine"];
				$res1 = $conn->query("select * from fine where username = '$regnm'");
				if($res1->num_rows > 0){
					$result = $conn->query("update fine set fine = (fine + $fine) where username = '$regnm'");
				}else{
					$result = $conn->query("insert into fine values ('$regnm',$fine)");
				}
				$res = $conn->query("delete from issue_book where bid='$bknam' and sid='$regnm'");
				if($res){
					echo "<script>alert('Book returned successfully.');</script>";
				}else{
					echo "<script>alert('Error occurred. Connection Problem.');</script>";
				}
			}
		?>
	</div>

	<script type="text/javascript">

		addEventOnButt = function(){
			let butlis = document.querySelectorAll('table .button-list');
			butlis.forEach(li=>{
				li.addEventListener('click',retBook);
			});
		}

		function retBook(ev){
			var val = ev.target.getAttribute('value');
			document.getElementById('regnam').value = document.getElementById('regn_'+val).innerHTML;
			document.getElementById('bknam').value  = document.getElementById('bkid_'+val).innerHTML;
			document.getElementById('bkfine').value = document.getElementById('fine_'+val).innerHTML;
			document.getElementById('confirmPop').style.display = 'block';
		}

		document.addEventListener('DOMContentLoaded',addEventOnButt);
	</script>
</body>
</html>
<?php } ?>
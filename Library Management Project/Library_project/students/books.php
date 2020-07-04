<?php
	include "stunavi.php";
if(isset($_SESSION["login_user"])){
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<style type="text/css">
body {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;
    /*background: #004528;*/
}
.sidenav {
    height: 100%;
    margin-top: 75px;
    width: 0px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #333;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}
.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
    color: #818181;
    text-decoration: none;
}

.sidenav a {
	padding: 8px 8px 8px 32px;
  	text-decoration: none;
  	font-size: 25px;
  	color: #818181;
 	display: block;
  	transition: 0.3s;
}
.opt{
	margin-top: 80px;
}
.opt a:hover 
{
	color:white;
	width: 300px;
	height: 50px;
	background-color: #00544c;
}
#mainpage{
	position: relative;
	transition: margin-left .5s;
  	padding: 16px;
}
	/*.sidenav a {
	    padding: 8px 8px 8px 32px;
	    text-decoration: none;
	    font-size: 25px;
	    color: #818181;
	    display: block;
	    transition: 0.3s;
	}*/

#srchbar input{
	margin:10px;
	margin-left: 75%;
	width: 250px;
	height: 30px;
	border-radius: 10px;
	outline: none; 
	background-color: rgba(0,0,0,0);
}
.table-book {
	border: 2px solid #ddd;
	max-width: 100%;
    border-spacing: 0;
    border-collapse: collapse;
}
.table1{
	width: 100%;
}
.table-book td,.table-book th {
	background-color: rgba(0,0,0,0);	
	border-top: 1px solid #ddd;
	border: 2px solid #ddd;
}
.table1 td,th{
	vertical-align: bottom;
	padding: 8px;
}
.center-td{
	text-align : center;
}

.table2 td{
	width: 200px;
}
.booktd div{
	border: 10px solid #ffff;
	text-align: center;
	padding-top: 20px;
	margin-right: 100px;
	color: white;
	width: 200px;
	height: 220px;
	background: red;
	margin-left: 100px;
	margin-top: 8px;
}

.booktd {
	width: 400px;
}
.totalCls{
	height: 60px;
}
#renew{
	padding: 15px;
	background-color: tomato;
	margin:50px;
	border-radius: 10px;
	margin-left: 500px;
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
</style>
</head>
<body>
	<div class="sidenav" id="sidenav">
		<a class="closebtn" onclick="closeNav()">&times;</a>
		<div class="opt">
			<a onclick="show_booksList()">Books</a>
			<a onclick="show_mybooksList()">MyBooks</a>
		</div>
	</div>
	<div class="mainpage" id="mainpage">
		<span style="font-size:30px;cursor:pointer" onclick="openNav()" id="openNav">&#9776;</span>
		<div class="Books" id="Books">
			<form action="books.php" id="srchbar" method="post">
				<input type="text" name="books_srch" placeholder="search...">
			</form>
			<h2>List Of Books</h2>
			<table class="table-book table1">
				<tr style="background-color: #6db6b9e6;">
					<th class="headth">ISSN</th>
					<th class="headth">Books Name</th>
					<th class="headth">Authors Name</th>
					<th class="headth">Edition</th>
					<th class="headth">Department</th>
					<th class="headth">Quantity<br> Available</th>
				</tr>
			<?php
				if(isset($_POST["books_srch"])){
					$na = $_POST["books_srch"];
					if($na == ""){
						$sql = "select * from books order by name";
					}else{
						$sql  = "select * from books where bid like '%$na%' or name like '%$na%' or authors like '%$na%' or edition like '%$na%' or department like '%$na%'"; 
					}
				}else{
					$sql = "select * from books order by name";
				}
				

				function LoadBooks($conn,$sql){
					$res = $conn->query($sql);
					while($row = $res->fetch_assoc()){
						echo (
							"<tr><td class='center-td'>".$row["bid"]."</td>".
							"<td>".$row["name"]."</td>".
							"<td>".$row["authors"]."</td>".
							"<td>".$row["edition"]."</td>".
							"<td>".$row["department"]."</td>".
							"<td>".$row["quantity"]."</td></tr>"
						);
					}
				}

				LoadBooks($conn,$sql);
			?>

			</table>
		</div>
		<div class="MyBooks" id="MyBooks" style="display: none;">
			<h2 style="margin-top: 30px;">List Of My Books</h2>

			<table class="table-book table2">
				<tr style="background-color: #6db6b9e6; height: 50px;" >
					<th>BOOKS</th>
					<th>Department</th>
					<th>Issue Date</th>
					<th>Return Date</th>
					<th>Fine</th>
					<th></th>
				</tr>
			<?php
				$count = 0;
				$res = $conn->query("SELECT * FROM `issue_book` JOIN books on issue_book.bid = books.bid WHERE sid='$user'");
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

				$total_fine = 0;

				while($row = $res->fetch_assoc()){
					$retndate = $row["return"];
					$today = Date('Y-m-d');
					$isue = $row["issue"];
					$fine = fineCalc($retndate,$today);
					$total_fine = $total_fine + $fine;
					$count = $count + 1;
					$bid = $row["bid"];
					$chekid = "check_".$count;
					$renewButId = "renew_".$count;
			?>
					<tr>
						<td class="booktd">
							<div>
								<p>
									<h2><?php echo $row["name"]; ?></h2>
									<br>
									<span id="issn">ISSN : <?php echo $bid; ?></span>
								</p>
								<br>
								<?php echo $row["authors"]; ?><br><?php echo $row["edition"]." Edition"; ?>
							</div>
						</td>
						<td class="center-td"><?php echo $row["department"]; ?></td>
						<td class="center-td"><?php echo $isue; ?></td>
						<td class="center-td"><?php echo $row["return"]; ?></td>
						<td class="center-td"><?php echo $fine; ?></td>
						<td class="center-td">
							<button class="renew-butt" id="<?php echo($renewButId) ?>" value="<?php echo($bid) ?>">
								Renew
							</button>
						</td>
					</tr>
			<?php
					$diff = (strtotime($retndate) - strtotime($isue))/86400;
					if($diff > 15){
						echo "<script>document.getElementById('$renewButId').disabled = true;</script>";
					}
				}
				echo "<script> var count = $count ; </script>";
				$result = $conn->query("select * from fine where username = '$user'");
				if(($result->num_rows)>0){
					while ($row = $result->fetch_assoc()){
						$userFine = $row["fine"];
					}
				}else{
					$userFine = 0;
				}
				$total_fine = $total_fine + $userFine;
			?>
				<tr>
					<td colspan="4" class="center-td totalCls"><h2>Previous fine</h2> </td>
					<td class="center-td totalCls" colspan="2"><h2><?php echo "$userFine"; ?></h2></td>
				</tr>
				<tr style="background-color: #b8a5a5;">
					<td colspan="4" class="center-td totalCls"><h2>Total fine</h2> </td>
					<td class="center-td totalCls" colspan="2"><h2><?php echo "$total_fine"; ?></h2></td>
				</tr>
			</table>
		</div>
	</div>


	<div id = "popUp" class="confirm-popup">
		<center>
			<form action="books.php" method="post">
				<input type="text" name="issnbk" id="issnbk-id" style="display: none;">
				<h2>Are you sure?</h2>
				<button type="submit" name="subyes" id="subyes">Yes</button>
			</form>
			<button onclick="document.getElementById('popUp').style.display='none'">No</button>
		</center>

		<?php
			if(isset($_POST["subyes"])){
				$bookId = $_POST["issnbk"];
				$res = $conn->query("select * from issue_book where bid = '$bookId' and sid = '$user'");
				while ($row = $res->fetch_assoc()) {
					$returnDate = $row["return"];
					$todayDate = Date('Y-m-d');
					$fine = fineCalc($returnDate,$todayDate);
					$newReturn = strtotime($returnDate) + (15*86400);
					$newReturnDate = Date('Y-m-d',$newReturn);
					echo "<script>alert('$newReturnDate')</script>";
					$res1 = $conn->query("select * from fine where username = '$user'");
					if(($res1->num_rows)>0){
						$res2 = $conn->query("update fine set fine = (fine + $fine) where username = '$user'");
					}else{
						$res2 = $conn->query("insert into fine values('$user',$fine)");
					}
					$res3 = $conn->query("UPDATE `issue_book` SET `return`='$newReturnDate' WHERE sid='$user' and bid='$bookId'");
					if($res3){
						?>
						<script>
							alert('Book Renewed Successfully.');
							window.location = "books.php";
						</script>";
						<?php
					}
				}
			}
		?>
	</div>
<script type="text/javascript">
	function openNav() {
		document.getElementById("sidenav").style.width = "300px";
		document.getElementById("mainpage").style.marginLeft = "300px";
		document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
		document.getElementById('openNav').style.color = 'rgba(0,0,0,0)';
	}

	function closeNav() {
		document.getElementById("sidenav").style.width = "0";
		document.getElementById("mainpage").style.marginLeft= "0";
		document.body.style.backgroundColor = "white";
		document.getElementById('openNav').style.color = '#333';
	}

	function show_booksList(){
		document.getElementById('Books').style.display = 'block';
		document.getElementById('MyBooks').style.display = 'none';
	}

	function show_mybooksList(){
		document.getElementById('MyBooks').style.display = 'block';
		document.getElementById('Books').style.display = 'none';
		closeNav();
	}

	function renewBook(ev){
		document.getElementById('issnbk-id').value = ev.target.value;
		document.getElementById('popUp').style.display = 'block';
	}
	document.addEventListener('DOMContentLoaded',function(){
		let lis = document.querySelectorAll('.renew-butt');
		lis.forEach(li=>{
			li.addEventListener('click',renewBook);
		});
	});
</script>
</body>
</html>
<?php
}
?>
<?php
	include "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	$user = $_POST["user"];
	$pass = $_POST["pass"];
	$res = $conn->query("select * from  students where id = '$user' and password ='$pass'");
	if(($res->num_rows)==0){
		$res=$conn->query("select * from admin where id = '$user' and password ='$pass'");
		if(($res->num_rows)==0){
			echo "<script>alert('wrong id or password');</script>";
			?>
			<script type="text/javascript">
				window.location = "index.php";
			</script>
			<?php
		}else{
			$_SESSION["login_user"] = $user;
			?>
			<script type="text/javascript">
				window.location = "books.php";
			</script>
			<?php
		}
	}else{
		$_SESSION["login_user"] = $user;
		?>
		<script type="text/javascript">
			window.location = "students/books.php";
		</script>
		<?php
	}
?>
</body>
</html>

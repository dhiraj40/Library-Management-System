<?php
   include "connection.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href = "social-media-icons.css">
  <meta charset="utf-8">
  <title>
    HomePage
  </title>
</head>
<body>
   <header>
      <nav>
        <div class="logo">
          <h2>LMP</h2>
        </div>
        <div class="menu">
          <a href="index.php">Home</a>
          <a href="#login_id">Log In</a>
          <a href="#Contact">Contact</a>
          <a href="#about">About</a>
        </div>
      </nav>
        <main>
          <section>
            <h3>WELCOME</h3>
            <h1>knowlege is power</h1>
            <p>we believe in you</p>
            <a href="#about" class="one">LEARN MORE</a>
            <a  onclick="document.getElementById('id01').style.display='block'" class="two">Sign Up</a>
          </section>
        </main>
    </header>

    <!-- Recomendation section -->
    <header>
        <main>
          <section>
            <h3>RECOMMENDED</h3>
            <p></p>
            <div class = 'reco_table'>
            <?php
              $sql = "select * FROM books order by checkout desc limit 6";
              $res = mysqli_query($conn,$sql);
              echo "<table><tr>";
              $c = 0;
              while ($row=mysqli_fetch_assoc($res)) {
                if ($c!=6) {
                  echo "<td><p>".$row["name"]."</p><br>".$row["authors"]."<br>".$row["edition"]." edition </td>";
                  $c += 1;
                  if($c%3==0){
                    echo "</tr><tr>";
                  }
                }
              }
              echo "</tr></table>";
            ?>
            </div>
          </section>
        </main>
    </header>

    <!--Sign in form-->
    <div id="login_id">
      <form class="signin_form"  action="signin.php" method="post">
      <div id="sign_in">
        <center><h3>Sign In</h3></center>
        <center><input type='text' name='user' class="sign_class" id='name_id' placeholder='Username' required></center><br>
        <center><input type='password' name='pass' class="sign_class" id='pass_id' placeholder='Password' required></center><br>
        <center><button type='submit' value='Sign in' name="but_sigin" id="but_signin">Sign in</button></center>
      </div>
      </form>
    </div>
    
    <!--About-->
    <div id="about">
    	<h2 style='color:tomato'>About Us</h2>
    	<p>A library is organized for use and maintained by a public body, an institution, a corporation, <br>or a private individual.</p>
    	<p>Public and institutional collections and services may be intended for use by people <br>who choose not to—or cannot afford to—purchase an extensive collection themselves, who need material no individual <br>can reasonably be expected to have, or who require professional assistance <br>with their research.</p>
    </div>

    <!---Contact link-->
    <div id="Contact">
    	<pre><span style='font-size:30px'>&#8212;</span>Contact Us</pre>
    	<h2>Contact our Support and Sales team</h2>
    	<p>Need to get in touch with the team? We’re all ears.</p>
    	<br>
    	<p>Phone no. : 0000000000000</p>
    	<p>Email : <a href=#>abcd@example.com</a></p>
    	<a href="#fb" class="fa fa-facebook"></a>
    	<a href="#tw" class="fa fa-twitter"></a>
    	<a href="#go" class="fa fa-google"></a>
    	<a href="#li" class="fa fa-linkedin"></a>
    	<a href="#yo" class="fa fa-youtube"></a>
    </div>


    <!--***********************Hidden World*******************************-->

    <!--Sign uP form on clicking Sign Up button from navigation-->
    <div id="id01" class="modal">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <form class="modal-content" action="index.php" method="post">
        <div class="container">
          <h1>Sign Up</h1>
          <p>Please fill in this form to create an account.</p>
          <hr>

    	  <label for="regno"><b>Registration no.</b></label>
          <input type="text" id= "regno" placeholder="Enter Registration no." name="regno" required><br>
          <div class="error-msg" id='reg-err'></div><br>

        <label for="user"><b>Name</b></label><br>
          <input type="text" id= "uname" placeholder="Enter Your Name" name="uname" required><br>

        <label for="email"><b>Email</b></label><br>
          <input type="text" id= "email" placeholder="Enter Email" name="email" required><br>
          <div class="error-msg" id='mail-err'></div>

    	  <label for="phone"><b>Phone no.</b></label><br>
          <input type="text" id= "phone" placeholder="Enter your Phone no." name="phone" required><br>
          <div class="error-msg" id='phon-err'></div>

        <label for="psw"><b>Password</b></label>
          <input type="password" id= "psw" placeholder="Enter Password" name="psw" required><br>
          <div class="error-msg" id='pas-err'></div>

        <label for="psw-repeat"><b>Repeat Password</b></label>
          <input type="password" id="psw_repeat" placeholder="Repeat Password" name="psw_repeat" required><br>
          <div class="error-msg" id='conpas-err'></div><br>

        <label>
          <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
        </label>

          <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
          <div class="clearfix">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
            <button type="submit" name="signupbtn" class="signupbtn">Sign Up</button>
          </div>
        </div>
        <?php
            if(isset($_POST["signupbtn"])){
              $reg = $_POST["regno"];
              $user = $_POST["uname"];
              $email = $_POST["email"];
              $phone = $_POST["phone"];
              $pass  = $_POST["psw"];
              $cpass  = $_POST["psw_repeat"];
              if(strlen($pass) >7 ){
                 if($pass==$cpass){
                   $res1 = mysqli_query($conn,"select * from Students where id = '$reg'");
                   if(mysqli_num_rows($res1) != 0){
                     echo "<script>document.getElementById('reg-err').innerHTML = 'User already exits.';</script>";
                   }else{
                     $res2 = mysqli_query($conn,"select * from appr_req where sid = '$reg'");
                     if (mysqli_num_rows($res2) != 0) {
                       echo "<script>document.getElementById('reg-err').innerHTML='Request sent already.';</script>";
                     }
                     else{
                       $sql = "Insert into appr_req values('$reg','$user','$email','$phone','$pass')";
                       $res = $conn->query($sql);
                       echo "<script type = text/javascript>alert('Request sent successfully. Wait for Approval.');</script>";
                     }
                   }
                     
                 }
                 else{
                   echo "<script>document.getElementById('conpas-err').innerHTML='Passwords not matched.';</script>";
                 }
              }else{
               echo "<script>document.getElementById('pass-err').innerHTML='Length of password must be 8.';</script>";
              }
              echo "<script>document.getElementById('id01').style.display = 'block';</script>";
            }
        ?>

      </form>
    </div>

   <script>
   // Get the modal
   var modal = document.getElementById('id01');

   // When the user clicks anywhere outside of the modal, close it
   window.onclick = function(event) {
      if (event.target == modal) {
         modal.style.display = "none";
      }
   }


   document.addEventListener('DOMContentLoaded',function(){
      document.getElementById('regno').addEventListener('input',UpCase);
      document.getElementById('email').addEventListener('input',mailCheck);
      document.getElementById('phone').addEventListener('input',phoneCheck);
      document.getElementById('psw').addEventListener('input',pswErrMsg);
      document.getElementById('psw_repeat').addEventListener('input',checkPass);
   });

   function UpCase(ev){
      ev.target.value = ev.target.value.toUpperCase();
   }

   function mailCheck(ev){
      var str = ev.target.value;
      var exp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(str.match(exp)){
          document.getElementById('mail-err').innerHTML = '';
      }else{
          document.getElementById('mail-err').innerHTML = 'Not valid Email Id.';
      }
   }

   function phoneCheck(ev){
      var str = ev.target.value;
      var exp = /^\d{10}$/;
      if(str.match(exp)){
          document.getElementById('phon-err').innerHTML = '';
      }else{
          document.getElementById('phon-err').innerHTML = 'Invalid phone number.';
      }
   }

   function pswErrMsg(ev){
      var val = ev.target.value;
      if(val.length <8){
        document.getElementById('pas-err').innerHTML = 'Password length must be at least 8.';
      }else{
        document.getElementById('pas-err').innerHTML = '';
      }
   }
   
   function checkPass(ev){
      var orgval = document.getElementById('psw').value;
      var conval = ev.target.value;
      if(orgval == conval){
        document.getElementById('conpas-err').innerHTML = '';
      }else{
        document.getElementById('conpas-err').innerHTML = 'password not matched';
      }
   }
   

   </script>
</body>
</html>

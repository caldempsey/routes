<?php
/* Main page with two forms: sign up and log in */
require 'static/php/MySQLI.Database.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
    <!--Uses PHP to get bootstrap head-->
    <?php include 'static/head/bootstrap.html'; ?>
    <!--Uses PHP to get navbar head-->
    <?php include 'static/head/navbar.html'; ?>
    <!--Use PHP to get custom login form-->
    <?php include 'static/head/login_system.html'; ?>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';

    }
}
?>
<body>


  <!-- BEGIN NAVBAR (INSERT VIA PHP) -->

   <?php include 'static/page_navbar/navbar.php'; ?>

    <!-- END OF NAVBAR -->


  <div class="form">
      
      <div class="content">

         <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="" method="post" autocomplete="off">
          
            <div class="field-wrap" title="Email Address">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="email"/>
          </div>
          
          <div class="field-wrap" title="Password">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="password"/>
          </div>
          
          <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
          
          <button class="button button-block" name="login">Log In</button>
          
          </form>

        </div>
          

        
      </div>
      
</div>
  <!-- Needs to go at the end for the form to work -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="static/js/index.js"></script>
</body>
</html>

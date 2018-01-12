<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <?php include 'static/head/login_system.html'; ?>
    <!--Uses PHP to get bootstrap head-->
    <?php include 'static/head/bootstrap.html'; ?>
    <!--Uses PHP to get navbar head-->
    <?php include 'static/head/navbar.html'; ?>
</head>

<body>


  <!-- BEGIN NAVBAR (INSERT VIA PHP) -->

   <?php include 'static/page_navbar/navbar.html'; ?>

    <!-- END OF NAVBAR -->







    <div class="form">
          <h1>Thanks for stopping by</h1>
              
          <p><?= 'You have been logged out!'; ?></p>
          
          <a href="index.php"><button class="button button-block"/>Home</button></a>

    </div>
</body>
</html>

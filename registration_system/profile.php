<?php
/* Displays user information and some useful messages */
session_start();
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?=$_SESSION['user_name']; ?></title>
  <?php include 'css/css.html'; ?>
</head>

<body>

  <div class="form">

          <h1>Welcome</h1>
          
          
         
          
          <h2><?php echo $_SESSION['user_name']; ?></h2>
          <p><?=$_SESSION['email'];?></p>
          
          <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>

    </div>
    
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

</body>
</html>

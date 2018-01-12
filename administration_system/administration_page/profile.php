<!DOCTYPE html>
<html>
  <head>
    <title>System Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!--Uses PHP to get bootstrap head info-->
    <?php include 'static/head/bootstrap.html'; ?>
    <!-- styles -->
    <link href="static/css/styles.css" rel="stylesheet">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="../static/vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="../static/vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="../static/vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="static/css/forms.css" rel="stylesheet">
    <!--Uses PHP to get navbar head info-->
    <?php include 'static/head/admin_navbar.html'; ?>
    <!--Uses PHP to get admin system plugins head info-->
    <?php include 'static/head/admin_plugins.html'; ?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) { //user logging in

        require '../login.php';

    }
}
?>
  </head>

<?php 
	session_start();
	$userName = $_SESSION['user_name'];
	if(!$userName){
		?> <script>	
		alert("Sorry, you not logging on ,log on first please!");
		url="../indexLogin.php";window.location.href=url;</script> <?php
		die();	
	}
?>


  <body>

  <!-- Uses PHP to get the default navbar -->

   <?php include 'static/page_navbar/admin_navbar.php'; ?>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="profile.php"><i class="glyphicon glyphicon-home"></i> Homepage</a></li>
                    <li><a href="trainPage.php"><i class="glyphicon glyphicon-road"></i>Train</a></li>
                    <li><a href="stationPage.php"><i class="glyphicon glyphicon-map-marker"></i>Station</a></li>
                    <li><a href="railwayLinePage.php"><i class="glyphicon glyphicon-registration-mark"></i>RailwayLine</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-time"></i> Schedules
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="scheduleTrainPage.php">Trains</a></li>
                            <li><a href="scheduleStationPage.php">Stations</a></li>
                        </ul>
                    </li>        
                </ul>
             </div>
		  </div>
		  


		  <div class="col-md-10">


		  	<div class="row">
		  		<div class="col-md-12">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title ">Welcome to trainLine administration system</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
						<?php echo "Hi, " ?>	
						<?php echo $userName ?>	
			  			<br /><br />
					</div>
		  		</div>
		  	</div>
		  </div>		  
		  

		</div>
    </div>
  </body>
</html>
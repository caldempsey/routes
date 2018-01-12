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


  </head>

<?php 
	session_start();
	if(!$_SESSION['user_name']){
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
	  				<div class="col-md-5">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title">Add RailwayLine</div>
					        </div>
			  				<div class="panel-body">
			  					<form action="addRailwayLine.php"  method="post">
									<fieldset>
										<div class="form-group">
											<label>Railway Line Name</label>
											<input id="railwayLineName" name="railwayLineName" class="form-control" type="text">
										</div>									
									</fieldset>
									<div>
										<input class="btn btn-primary" type="submit" value="submit">
									</div>
								</form>
			  				</div>
			  			</div>
	  				</div>
	  				

	  				<div class="col-md-7">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title">Add Station to RailwayLine</div>
					        </div>
			  				<div class="panel-body">
			  					<form action="addStationToRailwayLine.php"  method="post">
									<fieldset>
										<div class="form-group">
											<label>Railway Line Name</label>
											<input id="railwayLineName" name="railwayLineName" class="form-control" type="text">
										</div>	
										<div class="form-group">
											<label>Station ID</label>
											<input id="stationID" name="stationID" class="form-control" type="text">
										</div>
										<div class="form-group">
											<label>Station Position</label>											
											<input id="position" name="position" class="form-control" type="text">
										</div>																				
									</fieldset>
									<div>
										<input class="btn btn-primary" type="submit" value="submit">
									</div>
								</form>
			  				</div>
			  			</div>
	  				</div>	  				  			
	  			</div>	  		
	  				  				  			
	  			<?php 	  			
		  			require_once '../static/php/PDO.Database.php';
					try {
					    $database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
					} catch(PDOException $e) {
						echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
					}	
					$QueryResults_railwayLine = $database->query("select * from RailwayLines");
					//Returns each row in its own array and those results are in an array, so [[]]
					$railwayLinesArray = $QueryResults_railwayLine->fetchAll(PDO::FETCH_NUM);	

					$QueryResults_railwayLineWithStation = 
						$database->query("select Stations.id,Stations.name,RailwayLines.name,RailwayLinesStations.relative_position
						from Stations,RailwayLines,RailwayLinesStations 
						where (Stations.id=RailwayLinesStations.station_id && RailwayLines.id=RailwayLinesStations.railwayline_id)");
					$railwayLinesWithStationArray = $QueryResults_railwayLineWithStation->fetchAll(PDO::FETCH_NUM);
					$database->terminateConn();
	  			?>
	  				  				  			
	  			<div class="row">		
	  				<div class="col-md-5">										
							<div class="content-box-large">
			  				<div class="panel-heading">
								<div class="panel-title">Remove RailwayLine</div>
							</div>
			  				<div class="panel-body">			  						  				
			  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
									<thead>
										<tr>
											<th>Railway Line ID</th>
											<th>Railway Line name</th>
											<th>Remove</th>
										</tr>
									</thead>																		
									<tbody>
										<?php  foreach ($railwayLinesArray as $row): ?>
										<form action="deleteRailwayLine.php" method="post">										
											<tr>
												<td>
												<input id="railwayLineID" name="railwayLineID" class="form-control" type="hidden" 
													value="<?php print $row[0]?>"  readonly="readonly">
												<?php print $row[0]?>							
												</td>
												<td>
												<input id="railwayLineName" name="railwayLineName" class="form-control" type="hidden"
													value="<?php print $row[1]?>" readonly="readonly">	
												<?php print $row[1]?>						
												</td>
												<td><input class="btn btn-primary" type="submit" value="remove" 
													onclick ="return confirm('This will remove all information related to this railway line (stations, schedules, and trains). Please confirm this operation.')">
												</td>
											</tr>
										</form>
										<?php endforeach; ?>
									</tbody>
								</table>
	  						</div>
	  					</div>	  				  		
		 			</div>
	  				<div class="col-md-7">										
							<div class="content-box-large">
			  				<div class="panel-heading">
								<div class="panel-title">Remove Station from RailwayLine</div>
							</div>
			  				<div class="panel-body">			  						  				
			  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
									<thead>
										<tr>
											<th>Station ID</th>
											<th>Station Name</th>
											<th>Railway Line Name</th>
											<th>Position</th>
											<th>Remove</th>
										</tr>
									</thead>																		
									<tbody>
									
										<?php  foreach ($railwayLinesWithStationArray as $row): ?>
										<form action="deleteStationFromRailwayLine.php" method="post">										
											<tr>
												<td>
												<input id="stationID" name="stationID" class="form-control" type="hidden" 
													value="<?php print $row[0]?>"  readonly="readonly">
												<?php print $row[0]?>							
												</td>
												<td>
												<input id="stationName" name="stationName" class="form-control" type="hidden" 
													value="<?php print $row[1]?>"  readonly="readonly">
												<?php print $row[1]?>							
												</td>												
												<td>
												<input id="railwayLineName" name="railwayLineName" class="form-control" type="hidden"
													value="<?php print $row[2]?>" readonly="readonly">	
												<?php print $row[2]?>						
												</td>
												<td>
												<input id="position" name="position" class="form-control" type="hidden"
													value="<?php print $row[3]?>" readonly="readonly">	
												<?php print $row[3]?>						
												</td>												
												<td>
												<input class="btn btn-primary" type="submit" value="remove"
												onclick ="return confirm('This will remove all information related to this station (railwaylines, schedules, and trains). Please confirm this operation.')">
												</td>
											</tr>
										</form>
										<?php endforeach; ?>
										
									</tbody>
								</table>
	  					</div>
	  				</div>	  				  		
		 	</div>		 	
		</div>
    </div>
  </body>
</html>
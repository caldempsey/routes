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
                            <div class="panel-title">Add a Station to a Train's Schedule</div>
                        </div>
                        <div class="panel-body">
                            <form action="addStationSchedule.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Train Schedule ID</label>
                                        <input id="trainScheduleID" name="trainScheduleID" class="form-control"
                                               type="text" title="Train Schedule ID">
                                    </div>
                                    <div class="form-group">
                                        <label>Station ID</label>
                                        <input id="stationScheduleID" name="stationScheduleID" class="form-control" type="text"
                                               title="Station Schedule ID">
                                    </div>
                                    <div class="form-group">
                                        <label>Arrival Time</label>
                                        <div>
                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="today"
                                                 data-name="arrivalDate"></div>
                                            <div class="bfh-timepicker" data-name="arrivalTime"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Departure Time</label>
                                        <div>
                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="today"
                                                 data-name="departureDate"></div>
                                            <div class="bfh-timepicker" data-name="departureTime"></div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div>
                                    <input class="btn btn-primary" type="submit" value="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                require_once '../static/php/PDO.Database.php';
                try {
                    $database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
                } catch (PDOException $e) {
                    echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
                }
                $QueryResults_stationSchedules = $database->query("SELECT StationTrainSchedules.trainschedule_id, StationTrainSchedules.station_id, Stations.name, StationTrainSchedules.arrive_time, StationTrainSchedules.departure_time 
        FROM StationTrainSchedules
        INNER JOIN Stations
        ON Stations.id = StationTrainSchedules.station_id
        ORDER BY trainschedule_id ASC, arrive_time ASC;;");
                //Returns each row in its own array and those results are in an array, so [[]]
                $stationSchedulesArray = $QueryResults_stationSchedules->fetchAll(PDO::FETCH_NUM);
                $database->terminateConn();
                ?>


                <div class="col-md-7">
                    <div class="content-box-large">
                        <div class="panel-heading">
                            <div class="panel-title">Remove a Station from Train's Schedule</div>
                        </div>
                        <div class="panel-body">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                                   id="example">
                                <thead>
                                <tr>
                                    <th>Train Schedule ID</th>
                                    <th>Station Schedule ID</th>
                                    <th>Station Name</th>
                                    <th>Arrival Time</th>
                                    <th>Departure Time</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($stationSchedulesArray as $row): ?>
                                    <form action="deleteStationSchedule.php" method="post">
                                        <tr>
                                            <td>
                                                <input id="stationScheduleID" name="stationScheduleID" class="form-control"
                                                       type="hidden"
                                                       value="<?php print $row[0] ?>" readonly="readonly">
                                                <?php print $row[0] ?>
                                            </td>
                                            <td>
                                                <input id="stationID" name="stationID"
                                                       class="form-control" type="hidden"
                                                       value="<?php print $row[1] ?>" readonly="readonly">
                                                <?php print $row[1] ?>
                                            </td>
                                            <td>
                                                <input id="stationName" name="stationName"
                                                       class="form-control" type="hidden"
                                                       value="<?php print $row[2] ?>" readonly="readonly">
                                                <?php print $row[2] ?>
                                            </td>
                                            <td>
                                                <input id="arriveTime" name="arriveTime" class="form-control"
                                                       type="hidden"
                                                       value="<?php print $row[3] ?>" readonly="readonly">
                                                <?php print $row[3] ?>
                                            </td>
                                            <td>
                                                <input id="departureTime" name="departureTime" class="form-control"
                                                       type="hidden"
                                                       value="<?php print $row[4] ?>" readonly="readonly">
                                                <?php print $row[4] ?>
                                            </td>
                                            <td><input class="btn btn-primary" type="submit" value="remove"
                                                       onclick="return confirm('This will remove all information related to this schedule. Please confirm this operation.')">
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
    </div>
</div>
</body>
</html>
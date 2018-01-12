<!--delete station-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
	//$userID= $_POST["userID"];	
	$userID='1';

	$stationID=$_POST["stationID"];
	$stationScheduleID=$_POST["stationScheduleID"];
	$arriveTime=$_POST["arriveTime"];
	$departureTime=$_POST["departureTime"];
	
	require_once '../static/php/PDO.Database.php';
	try {
		$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
		echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
	}	
	
	//if user doesn't exist, link to defalut page
	if ($userID == null) {
		?> <script>alert("permission denied");
			url="stationPage.php";window.location.href=url;</script> <?php	
	}
	//else check stationID, whether stationID exsit?
	else {
		$database->query("delete from StationTrainSchedules 
			where station_id='$stationID'&&trainschedule_id='$stationScheduleID'
			&&arrive_time='$arriveTime'&&departure_time='$departureTime'");				
	}
	$database->terminateConn();
	?> <script>	url="scheduleStationPage.php";window.location.href=url;</script> <?php
?>
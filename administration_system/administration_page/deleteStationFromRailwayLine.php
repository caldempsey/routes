<!--delete station-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];		
	$userID='1';

	$railwayLineName=$_POST["railwayLineName"];
	$stationID=$_POST["stationID"];
	$position=$_POST["position"];
	
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
		$QueryResults_railwayLineID = $database->query("select id from RailwayLines where name='$railwayLineName'");
		$Row_railwayLineID = $QueryResults_railwayLineID->fetchAll(MYSQLI_BOTH);		
		$SQL_railwayLineID = $Row_railwayLineID[0][0];	
			
		$database->query("delete from RailwayLinesStations 
			where railwayline_id='$SQL_railwayLineID'&&relative_position='$position'&&station_id='$stationID';");				
	}
	$database->terminateConn();
	?> <script>	url="railwayLinePage.php";window.location.href=url;</script> <?php
?>
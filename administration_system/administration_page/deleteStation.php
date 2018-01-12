<!--delete station-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];		
	$userID='1';

	$stationID=$_POST["stationID"];
	$stationName=$_POST["stationName"];
	$mnemonic=$_POST["mnemonic"];
	
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
		require_once 'Station.php';
		$station = new Station($stationID, $stationName, $mnemonic);

		$station->deleteStation($database);
	}
	$database->terminateConn();
	?> <script>	url="stationPage.php";window.location.href=url;</script> <?php
?>
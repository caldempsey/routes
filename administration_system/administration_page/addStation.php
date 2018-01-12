<!--add station-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];
	$userID='1';   //use it to test, delete it
	
	$stationID='1';
	$stationName=$_POST["stationName"];
	$mnemonic=$_POST["mnemonic"];
	
	require_once '../static/php/PDO.Database.php';	
	try {
    	$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
        echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
    }
	
	//if user doesn't exist, link to defalut page
	//if lineID or lineName is empty, link to defalut page
	//else check whether lineID or lineName exist
	if ($userID == null) {
		?> <script>alert("permission denied");
		url="stationPage.php";window.location.href=url;</script> <?php	
	} else if ($stationName == null || $mnemonic == null){
		?> <script>alert("invalid input");
		url="stationPage.php";window.location.href=url;</script> <?php		
	} else {
		
		require_once 'CheckExists.php';
		$queryChecker = new CheckExists;
		$checkExists_mnemonic = $queryChecker->doesStationMnemonicExist($database, $mnemonic);
		
		if ($checkExists_mnemonic == true) {
			?> <script>alert("mnemonic exist");
			url="stationPage.php";window.location.href=url;</script> <?php	
		} else {
			require_once 'Station.php';
			$station = new Station($stationID, $stationName, $mnemonic);

			$station->addStation($database);
		}
	}
	$database->terminateConn();
	?> <script>	url="stationPage.php";window.location.href=url;</script> <?php	
?>
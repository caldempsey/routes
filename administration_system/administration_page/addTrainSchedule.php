<!--add train schedule-->
<!--make sure userID is not null, then check whether stationID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];		
	$userID='1';

	$trainID=$_POST["trainID"];
	
	require_once '../static/php/PDO.Database.php';
	try {
		$database = new Database("mysql:host=localhost;dbname=t8005t06", 't8005t06', 'CorkCubeNode');
	} catch(PDOException $e){
		echo "A critical error has occurred, connection to internal database failed: " . $e->getMessage();
	}	

	//if user doesn't exist, link to defalut page
	if ($userID == null) {
		?> <script>alert("permission denied");
			url="scheduleTrainPage.php";window.location.href=url;</script> <?php	
	} else if ($trainID == null){
		?> <script>alert("invalid input");
		url="scheduleTrainPage.php";window.location.href=url;</script> <?php		
	} else {		
		require_once 'CheckExists.php';
		$queryChecker = new CheckExists();
		$checkExists_trainID = $queryChecker->doesTrainExist($database, $trainID);
		
		
		if ($checkExists_trainID != true) {
			?> <script>alert("train doesn't exist");
			url="scheduleTrainPage.php";window.location.href=url;</script> <?php	
		} else {
			$database->query("insert into TrainSchedules values(null, $trainID)");
		}		
    }
	$database->terminateConn();
	?> <script>	url="scheduleTrainPage.php";window.location.href=url;</script> <?php	
?>
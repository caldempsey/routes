<!--delete railway line-->
<!--make sure userID is not null, then check whether lineID exist-->

<?php @session_start();
	//$userID =$_SESSION['userID'];	
	$userID='1';
	
	$scheduleID=$_POST["scheduleID"];
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
	} else {
		$database->query("delete from TrainSchedules 
			where (id = '$scheduleID' && train_id = '$trainID')");
	}

	$database->terminateConn();
	?> <script>	url="scheduleTrainPage.php";window.location.href=url;</script> <?php		
?>
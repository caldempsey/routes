<?php

class Station
{
    private $stationID;
    private $stationName;
    private $mnemonic;

    /**
     * Station constructor.
     * @param $stationID
     * @param $stationName
     * @param $mnemonic
     */
    function __construct($stationID, $stationName, $mnemonic)
    {
        $this->stationID=$stationID;
        $this->stationName=$stationName;
        $this->mnemonic=$mnemonic;
    }
    
    function getNameByID($stationID,$database)
    {
		$QueryResults = $database->query("select name from Stations where id='$stationID'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getIDByName($stationName,$database)
    {
		$QueryResults = $database->query("select id from Stations where name='$stationName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getNameByName($stationName,$database)
    {
		$QueryResults = $database->query("select name from Stations where name='$stationName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }
    
    function getMnemonicByMnemonic($mnemonic,$database)
    {
		$QueryResults = $database->query("select mnemonic from Stations where mnemonic='$stationName'");
		$Row = $QueryResults->fetchAll(MYSQLI_BOTH);
		return $Row[0][0];
    }

    function addStation($database)
    {
    	$database->query("insert into Stations values
    		(null,'$this->stationName','$this->mnemonic')");
    }
    
    function deleteStation($database)
    {
    	$database->query("delete from Stations where id = '$this->stationID'");
    }
}
?>
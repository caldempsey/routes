<?php

class Database
{
    private $conn;

    /**
     * Database constructor.
     * @param $serverDetails
     * @param $username
     * @param $password
     * @param $schema
     */
    function __construct($serverDetails, $username, $password)
    {
        $conn = new PDO($serverDetails, $username, $password);
        //Sets database handler to throw exceptions on error.
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn = $conn;
    }

    /**
     * @return PDO
     */
    private function getConn()
    {
        return $this->conn;
    }

    function terminateConn()
    {
        $this->setConn(null);
    }

    function setQuery($query)
    {
        // Prepare statement using the database.
        $statement = $this->getConn()->prepare($query);
        // Return the prepared statement from the database.
        return $statement;
    }

    /**
     * /* Get array of results TrainScheduleId, StationId, ArriveTime, DepartureTime *
     * @param $departureUnixTime
     * @return array
     * @internal param $departureDate
     * @internal param $departureTime
     */
    function getAllDeparturesAfterUnixTime($departureUnixTime)
    {   /*Set the query we will be using.*/
        $stmt = $this->getConn()->prepare("SELECT StationTrainSchedules.trainschedule_id, StationTrainSchedules.station_id, Stations.name, StationTrainSchedules.arrive_time, StationTrainSchedules.departure_time 
        FROM StationTrainSchedules
        INNER JOIN Stations
        ON Stations.id = StationTrainSchedules.station_id
        WHERE departure_time > from_unixtime(?)  
        ORDER BY trainschedule_id ASC, arrive_time ASC;");

        /*Bind the departing unix time to the SQL query (above)*/
        $stmt->bindParam(1, $departureUnixTime, PDO::PARAM_STR);
        $stmt->execute();
        //Fetch the results as an array (of arrays of rows)
        return $result = $stmt->fetchAll(PDO::FETCH_NUM );
    }
    function getStationIdFromMnemonic($mnemonic)
    {   /*Set the query we will be using.*/
        $stmt = $this->getConn()->prepare("SELECT Stations.id
        FROM Stations
        WHERE Stations.mnemonic = ?;");

        $stmt->bindParam(1, $mnemonic, PDO::PARAM_STR);
        $stmt->execute();
        //Fetch the results as an array (of arrays of rows)
        return $result = $stmt->fetch(PDO::FETCH_NUM );
    }

    function getAllStationNameMnemonics()
    {
        /*Set the query we will be using.*/
        $stmt = $this->getConn()->prepare("SELECT name, mnemonic FROM Stations
ORDER BY name ASC;");
        $stmt->execute();
        //Fetch the results as an array (of arrays of rows)
        return $result = $stmt->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * @param $conn
     */
    private function setConn($conn)
    {
        $this->conn = $conn;
    }

    function query($statement){
        $result = $this->getConn()->query($statement);
        return $result;
    }
}

<?php

//Database results parser is a service class responsible for simply parsing results arrived from the MySQL database.
class DatabaseResultsParser
{
    /**
     * Takes an input MYSQL FETCH_NUM array (as an input train schedule) and returns a train schedules object.
     * @param $inputSchedule
     * @return TrainSchedules
     */
    function generateTrainSchedulesFromArray($inputSchedule)
    {
        /*Declare variables we will use*/
        $trainSchedules = new TrainSchedules();
        $currentTrainStationId = null;
        $lastTrainStationId = null;
        $trainSchedule = null;
        /*Begin loop*/
        foreach ($inputSchedule as $key => $row) {
            $currentTrainStationId = (int)$row[0];
            if ($currentTrainStationId != $lastTrainStationId) {
                $trainSchedule = new trainSchedule($currentTrainStationId);
                $trainSchedules->push($trainSchedule);
            }
            $stationStop = new StationStop((int)$row[1], (string)($row[2]), $this->convertMySQLDateToDateTime($row[3]), $this->convertMySQLDateToDateTime($row[4]));
            $trainSchedule->push($stationStop);
            $lastTrainStationId = (int)$row[0];
        }
        return $trainSchedules;
    }

    /**
     * Converts MySQL default date information to a PHP library DateTime object.
     * @param $date
     * @return DateTime|false
     */
    function convertMySQLDateToDateTime($date)
    {
        return date_create_from_format("Y-m-d H:i:s", $date);
    }
}

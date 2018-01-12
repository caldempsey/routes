<?php

// The TrainSchedules class models a collection of trains routes . Please see the readme for more details on this.
class TrainSchedules extends SplDoublyLinkedList
{
    public $toString = "Array of Train Schedules.";

    public function offsetSet($key, $val)
    {
        if ($val instanceof TrainSchedule) {
            return parent::offsetSet($key, $val);
        }
        throw new InvalidArgumentException('Value must be a TrainSchedule');
    }


    /**
     * Performs a depth first search and performs the algorithm wto generates and assigns the connections between stations using the strategy as outlined in README.TXT
     * @param $sourceNode
     * @param $destinationNodeSetId
     * @return SplDoublyLinkedList
     */
    function generatePathsToStationIdFromNode($sourceNode, $destinationNodeSetId)
    {
        /*Use a depth first search to get the fastest route*/
        $stack = new SplStack();
        $seenNodes = new SplDoublyLinkedList();
        $stack->push($sourceNode);
        $destinationNodes = new SplDoublyLinkedList();
        while (!$stack->isEmpty()) {
            //Begin assuming no knowledge of connecting stations.
            $lineEnd = true;
            // Get the item from the top of the stack.
            $currentNode = $stack->pop();
            //Get all the neighbors from the top item of the stack.
            $nodeConnections = $this->getAllStationConnections($currentNode);
            //If the node connections are empty then we know that we have reached the end of a railway line.
            if (!$nodeConnections->isEmpty()) {
                $lineEnd = false;
            }
            //Append the current node to seen connections.
            $seenNodes->push($currentNode);
            //If this is not the end of a railway line investigate whether the nodes have been seen.
            // If the node has been seen then do not add it to the stack, otherwise add it to the stack.
            if (!$lineEnd) {
                foreach ($nodeConnections as $connection) {
                    $seen = false;
                    foreach ($seenNodes as $seenNode) {
                        if ($connection == $seenNode) {
                            $seen = true;
                        }
                    }
                    //If the connection has not been seen then annotate a path to it, then add it to the stack.
                    if (!$seen) {
                        $connection->setNodeFrom($currentNode);
                        //If this is one of our destination nodes then we need to keep track of that object.
                        //We achieve this by assigning the object knowledge of what route was used to get there.
                        if ($connection->getStationId() == $destinationNodeSetId) {
                            $destinationNodes->push($connection);
                        }
                        $stack->push($connection);
                    }
                }
            }
        }
        return $destinationNodes;
    }

    /**
     * Gets all the station connections available from one scheduled station stop.
     * To illustrate if Train Schedule A arrives at Station A and Train Schedule B arrives at Station A at the same time as Train Schedule A, then this identifies that the connection of Train Schedule B must be a connection of Train Schedule A.
     * In effect, this method returns all connections of a station-event node a train is scheduled to arrive at.
     * @param $stationStop
     * @return SplDoublyLinkedList
     */
    function getAllStationConnections($stationStop)
    {
        $connections = new SplDoublyLinkedList();
        $stationId = $stationStop->getStationId();
        foreach ($this as $trainSchedule) {
            //If a train in the train schedule has the same station ID, find whether or not we arrive to that station before that trains departure.
            if ($trainSchedule->hasStationId($stationId)) {
                $candidateStation = $trainSchedule->getStationById($stationId);
                //If we arrive to that station before the trains departure then we are able to reach its connection
                if ($candidateStation->getDepartureDateTime() > $stationStop->getArrivalDateTime()) {
                    //First we need to check if it has a connection (to be typesafe).
                    if ($trainSchedule->hasStationConnection($candidateStation)) {
                        $connection = $trainSchedule->getStationConnection($candidateStation);
                        //If there exists a connection then append it to the list of connections.
                        $connections->push($connection);
                    }
                }
            }

        }
        return $connections;
    }


    /**
     * Identifies given raw input details for a station schedule node, whether or not it exists in any train schedule.
     * @param $stationId
     * @param $arrivalDateTime
     * @param $departureDateTime
     * @return bool
     */
    function hasStationStopNode($stationId, $arrivalDateTime, $departureDateTime)
    {
        if ($stationId < 0) {
            die("Station ID must be a value larger than 0.");
        }
        if ($arrivalDateTime >= $departureDateTime) {
            die ("Arrival date or time must be a larger value than the departure date or time.");
        }
        foreach ($this as $trainSchedule) {
            foreach ($trainSchedule as $stationStop) {
                if (($stationStop->getStationId() == $stationId) && ($stationStop->getArrivalDateTime() == $arrivalDateTime) && ($stationStop->getDepartureDateTime() == $departureDateTime)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the station schedule node corresponding to an arrival and departure date time, returns null if not found in any train schedule.
     * @param $stationId
     * @param $arrivalDateTime
     * @param $departureDateTime
     * @return null
     */
    function getStationStopNode($stationId, $arrivalDateTime, $departureDateTime)
    {
        //Validate input by building a pseudo object.
        if ($stationId < 0) {
            die("Station ID must be a value larger than 0.");
        }
        if ($arrivalDateTime >= $departureDateTime) {
            die ("Arrival date or time must be a larger value than the departure date or time.");
        }
        foreach ($this as $trainSchedule) {
            foreach ($trainSchedule as $stationStop) {
                if (($stationStop->getStationId() == $stationId) && ($stationStop->getArrivalDateTime() == $arrivalDateTime) && ($stationStop->getDepartureDateTime() == $departureDateTime)) {
                    return $stationStop;
                }
            }
        }
        return null;
    }

    /**
     * Returns the station schedule time-extended node
     * @param $node
     * @return null
     */
    function getNode($node)
    {
        foreach ($this as $trainSchedule) {
            foreach ($trainSchedule as $stationStop) {
                if ($node === $stationStop) {
                    return $stationStop;
                }
            }
        }
        return null;
    }


    /**
     * Gets the next departing Station Stop Node departing from a Station ID.
     * @param $stationId
     * @return null
     */
    function getNextDepartingStationStopNode($stationId)
    {
        //Initialize Variables.
        $nextDepartingStationStopNode = null;
        foreach ($this as $trainSchedule) {
            //Check if a station ID exists
            if ($trainSchedule->hasStationId($stationId)) {
                //If so we have found a station node candidate.
                $foundStation = $trainSchedule->getStationById($stationId);
                //Check if this is the first node we have found.
                if ($nextDepartingStationStopNode == null) {
                    $nextDepartingStationStopNode = $foundStation;
                    continue;
                    //If this is not the first candidate then we need to compare the departure date times.
                } else if ($nextDepartingStationStopNode != null) {
                    //If the departure date time of the saved station is greater than the departure date time of the new station replace it as our next departing station node.
                    if ($nextDepartingStationStopNode->getDepartureDateTime() > $foundStation->getDepartureDateTime()) {
                        $nextDepartingStationStopNode = $foundStation;
                    }
                }
            }
        }
        return $nextDepartingStationStopNode;
    }

    /**
     * Overrides toString method.
     * @return string
     */
    function __toString()
    {
        return $this->toString;
    }
}

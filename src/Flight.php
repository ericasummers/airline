<?php
    class Flight
    {
        private $id;
        private $status;
        private $departure_time;
        private $arrival_time;

        function __construct($status, $departure_time, $arrival_time, $id = null)
        {
            $this->status = $status;
            $this->departure_time = $departure_time;
            $this->arrival_time = $arrival_time;
            $this->id = $id;
        }

        function getStatus()
        {
            return $this->status;
        }

        function setStatus($new_status)
        {
            $this->status = (string) $new_status;
        }

        function getDepartureTime()
        {
            return $this->departure_time;
        }

        function setDepartureTime($new_time)
        {
            $this->departure_time = (string) $new_time;
        }

        function getArrivalTime()
        {
            return $this->arrival_time;
        }

        function setArrivalTime($new_time)
        {
            $this->arrival_time = (string) $new_time;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO flights (status, departure_time, arrival_time) VALUES ('{$this->getStatus()}', '{$this->getDepartureTime()}', '{$this->getArrivalTime()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_flights = array();
            $flights = $GLOBALS['DB']->query("SELECT * FROM flights;");
            foreach($flights as $flight) {
                $status = $flight['status'];
                $departure_time = $flight['departure_time'];
                $arrival_time = $flight['arrival_time'];
                $id = $flight['id'];
                $new_flight = new Flight($status, $departure_time, $arrival_time, $id);
                array_push($returned_flights, $new_flight);
            }
            return $returned_flights;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM flights;");
        }
    }







?>

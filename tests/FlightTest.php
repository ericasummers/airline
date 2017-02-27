<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";
    require_once "src/Flight.php";

    $server = 'mysql:host=localhost:8889;dbname=airline_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class FlightTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            City::deleteAll();
            Flight::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $status = "On time";
            $departure_time = "12:00:00";
            $arrival_time = "15:00:00";
            $new_flight = new Flight($status, $departure_time, $arrival_time);
            $new_flight->save();

            //Act
            $result = Flight::getAll();

            //Assert
            $this->assertEquals($new_flight, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $status = "On time";
            $departure_time = "12:00:00";
            $arrival_time = "15:00:00";
            $new_flight = new Flight($status, $departure_time, $arrival_time);
            $new_flight->save();

            $status2 = "Delayed";
            $departure_time2 = "16:00:00";
            $arrival_time2 = "18:00:00";
            $new_flight2 = new Flight($status2, $departure_time2, $arrival_time2);
            $new_flight2->save();

            //Act
            $result = Flight::getAll();

            //Assert
            $this->assertEquals([$new_flight, $new_flight2], $result);
        }

        function test_findFlight()
        {
            //Arrange
            $status = "On time";
            $departure_time = "12:00:00";
            $arrival_time = "15:00:00";
            $new_flight = new Flight($status, $departure_time, $arrival_time);
            $new_flight->save();

            $status2 = "Delayed";
            $departure_time2 = "16:00:00";
            $arrival_time2 = "18:00:00";
            $new_flight2 = new Flight($status2, $departure_time2, $arrival_time2);
            $new_flight2->save();

            //Act
            $result = Flight::findFlight($new_flight2->getId());

            //Assert
            $this->assertEquals($new_flight2, $result);
        }

        function test_updateProperty()
        {
            //Arrange
            $status = "On time";
            $departure_time = "12:00:00";
            $arrival_time = "15:00:00";
            $new_flight = new Flight($status, $departure_time, $arrival_time);
            $new_flight->save();

            $status2 = "Delayed";
            $departure_time2 = "16:00:00";
            $arrival_time2 = "18:00:00";
            $new_flight->updateProperty("status",$status2);
            $new_flight->updateProperty("departure_time",$departure_time2);
            $new_flight->updateProperty("arrival_time",$arrival_time2);


            //Act
            $result = Flight::findFlight($new_flight->getId());
            $result_array = array($result->getStatus(),$result->getDepartureTime(),$result->getArrivalTime(),$result->getId());
            $expected = array($status2,$departure_time2,$arrival_time2,$new_flight->getId());

            //Assert
            $this->assertEquals($expected, $result_array);
        }

        function test_delete()
        {
            //Arrange
            $status = "On time";
            $departure_time = "12:00:00";
            $arrival_time = "15:00:00";
            $new_flight = new Flight($status, $departure_time, $arrival_time);
            $new_flight->save();

            $status2 = "Delayed";
            $departure_time2 = "16:00:00";
            $arrival_time2 = "18:00:00";
            $new_flight2 = new Flight($status2, $departure_time2, $arrival_time2);
            $new_flight2->save();

            //Act
            $new_flight->delete();

            $this->assertEquals([$new_flight2], Flight::getAll());
        }



    }



?>

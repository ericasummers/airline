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

    class CityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            City::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $city_name = "Baltimore";
            $test_city = new City($city_name);
            $test_city->save();

            // Act
            $result = City::getAll();

            // Assert
            $this->assertEquals($test_city,$result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $city_name = "Baltimore";
            $test_city = new City($city_name);
            $test_city->save();
            $city_name2 = "Portland";
            $test_city2 = new City($city_name2);
            $test_city2->save();

            // Act
            $result = City::getAll();

            // Assert
            $this->assertEquals([$test_city,$test_city2],$result);
        }



    }

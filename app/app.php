<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Flight.php";
    require_once __DIR__."/../src/City.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=airline';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {

        return $app['twig']->render('index.html.twig', array('flights' => Flight::getAll(), 'cities' => City::getAll()));
    });

    $app->post("/add_flight", function() use ($app) {
        $departure_city = $_POST['id_city_departure'];
        $arrival_city = $_POST['id_city_arrival'];
        $status = $_POST['status'];
        $departure_time = $_POST['departure_time'];
        $arrival_time = $_POST['arrival_time'];
        $flight = new Flight($status, $departure_time, $arrival_time);
        $flight->save();
        $flight->addCities(City::findCity($departure_city), City::findCity($arrival_city));

        return $app['twig']->render('index.html.twig', array('flights' => Flight::getAll(), 'cities' => City::getAll()));
    });

    $app->post("/add_city", function() use ($app) {
        $city_name = $_POST['city_name'];
        $new_city = new City($city_name);
        $new_city->save();

        return $app['twig']->render('index.html.twig', array('flights' => Flight::getAll(), 'cities' => City::getAll()));
    });


    return $app;


?>

<?php
require __DIR__ . '/vendor/autoload.php';
require('./controllers/usuario.php');
require('./controllers/servicio.php');
require('./controllers/vehiculo.php');
require('./class/User.php');
require('./class/Servicio.php');
require('./class/Vehiculo.php');
require('./helpers/helper.php');


$metodo = $_SERVER['REQUEST_METHOD'] ?? "";
$path = $_SERVER['PATH_INFO'] ?? "";
$token = (getallheaders())['token'] ?? "";

switch ($metodo) {
    case 'POST':
        if($path == "/registro"){

            createUser(["tipo","email","password"]);
        }
        
        else if($path == "/login"){

            login(["email","password"]);
        }
        
        else if($path == "/vehiculo"){

            saveVehiculo(["marca","modelo","patente","precio"],$token);
        }

        else if($path == "/servicio"){

            addService(["id","tipo","precio","demora"],$token);
        }/*
        else if($path == "/stats"){

        }*/
        else{
            response(false,"BAD REQUEST","msg");
        }
        break;

    case 'GET':
        if($path == "/stats"){
            getAllAutos();

        }
        else if($path == "/turno"){
            

        }

    default:
        # code...
        break;
}

<?php

function ingresoVehiculo($params,$token){
    if(!validatorPost($params)){
        return;
    }
    $payload = validatorJWT($token);
    if( $payload == null ){
        response(false,"Token no valido","msg");
        return;
    }
    if( $payload->tipo != "user" ){
        response(false,"Solo los tipo:user pueden crear el ingreso","msg");
        return;
    }
    $newIngreso = new Vehiculo( date("g:i:a d-m-o"),$_POST["tipo"], $_POST["patente"],$_POST["marca"],$_POST["modelo"],$_POST["precio"],$payload->email);
    $response = $newIngreso->save();
    response(true,$response,"respuesta");
}


function saveVehiculo($params,$token){
    if(!validatorPost($params)){
        return;
    }
    $payload = validatorJWT($token);
    if( $payload == null ){
        response(false,"Token no valido","msg");
        return;
    }

    if(Vehiculo::getByPatente($_POST["patente"])!=null){
        response(false,"Patente ya registrada","msh");
        return;
    }

    $newVehiculo = new Vehiculo($_POST["marca"],$_POST["modelo"],$_POST["patente"],$_POST["precio"]);
    $newVehiculo->save();
    response(true,"Vehiculo guardado con exito","msg");
}



function getAllAutos(){
    response(true, Vehiculo::getAll(),"respuesta");
}


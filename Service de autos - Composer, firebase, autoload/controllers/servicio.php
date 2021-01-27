<?php

function addService($params,$token){
    if(!validatorPost($params)){
        return;
    }
    $payload = validatorJWT($token);
    if( $payload == null ){
        response(false,"Token no valido","msg");
        return;
    }
    $newService = new Servicio($_POST["id"],$_POST["tipo"],$_POST["precio"],$_POST["demora"]);
    $newService->save();
    response(true,"Service creado con exito","msg");
}
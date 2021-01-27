<?php
use \Firebase\JWT\JWT;

function response($ok,$data,$typeResponse){
    echo(
        json_encode(
            array(
                "ok"=> $ok,
                $typeResponse=> $data
            )
        )
    );
}


//Retorna un jwt
function createJWT($payload){
    $key = "example_key";
    $jwt = JWT::encode($payload,$key);
    return $jwt;
}

//Valida un jwt
function validarJWT($token){
    $retorno = null;
    $key = "example_key";
    try {
        $data = JWT::decode($token, $key, array('HS256'));
        $retorno = $data;
    } catch (\Throwable $th) {
       $retorno = null;
    }
    return $retorno;
}
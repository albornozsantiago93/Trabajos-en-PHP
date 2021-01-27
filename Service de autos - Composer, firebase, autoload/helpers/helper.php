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

//Retorna los datos leidos en el path en formato json
function getData($path){
    $file = fopen($path,"r");
    $dataList = fread($file,filesize($path));
    fclose($file);
    return json_decode($dataList);
}

//Guarda en path especificado un nuevo elemento en la dataList
function saveData($path,$newElement,$dataList){
    $file = fopen($path,"w");
    array_push($dataList,$newElement);
    fwrite($file,json_encode($dataList));
    fclose($file);
}

//Valida que la cantidad de parametros recibidos en post sea la correcta
function validatorPost($params){
    $retorno = true;
    for ($i=0; $i < count($params); $i++) { 
        if( !isset($_POST[$params[$i]]) ){
            response(false,"$params[$i] es obligatorio","msg");
            $retorno = false;
            break;
        }
    }
    return $retorno;
}

//Retorna un jwt
function createJWT($payload){
    $key = "example_key";
    $jwt = JWT::encode($payload,$key);
    return $jwt;
}

//Valida un jwt
function validatorJWT($token){
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
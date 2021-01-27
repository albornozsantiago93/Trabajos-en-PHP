<?php

function createUser($params){
    if(!validatorPost($params)){
        return;
    }
    if(User::getByEmail($_POST['email']) != null){
        response(false,"Ya existe un usuario con ese email","msg");
        return;
    }
    $newUser = new User($_POST['tipo'],$_POST['email'],$_POST['password']);
    $newUser->save();
    response(true,"Usuario Creado con exito","msg");
}

function login($params){
    if(!validatorPost($params)){
        return;
    }
    $user = User::getByEmailAndPassword($_POST['email'],$_POST['password']);
    if($user == null){
        response(false,"Email o Password incorrecto","msg");
        return;
    }
    $payload = array(
        "tipo"=>$user->tipo,
        "email"=>$user->email
    );
    $jwt = createJWT($payload);
    $response = array(
        "tipo"=>$user->tipo,
        "email"=>$user->email,
        "token"=>$jwt
    );
    response(true,$response,"user");
    
}



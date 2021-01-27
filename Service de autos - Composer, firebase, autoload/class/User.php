<?php

class User {

    public $tipo = "";
    public $email = "";
    public $password = "";
    public static $pathDataBase = "./data/usuarios.json";

    public function __construct($tipo,$email,$password){

        $this->tipo = $tipo ?? "user";
        $this->email = $email;
        $this->password = $password;
    }

    
    public function save(){
        $userList = getData(Self::$pathDataBase);
        $newUser = array(
            "tipo" => $this->tipo,
            "email" => $this->email,
            "password" => $this->password
        );
        saveData(Self::$pathDataBase,$newUser,$userList);
        return $newUser;
    }

    //Obtiene todoa la informacion del pathdata
    public static function getAll(){
        return getData(Self::$pathDataBase);
    }

    //busca en una lista el email, caso de encontrarlo lo retorna
    public static function getByEmail($email){
        $retorno = null;
        $userList = getData(Self::$pathDataBase);
        for ($i=0; $i < count($userList) ; $i++) { 
            if( $userList[$i]->email === $email ){
                $retorno = $userList[$i];
                break;
            }
        }
        return $retorno;
    }

    //retorna un usuario en el caso de obtener un email y este coincida con el password
    public static function getByEmailAndPassword($email,$password){
        $retorno = null;
        $user = Self::getByEmail($email);
        if($user != null){
            if( $user->password == $password){
                $retorno = $user;
            }
        }
        return $retorno;
    }

}
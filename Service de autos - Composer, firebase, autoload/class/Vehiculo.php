<?php

class Vehiculo {

    private $marca;
    private $patente;
    private $modelo;
    private $precio;

    public static $pathDataBase = "./data/vehiculos.json";

    public function  __construct($marca,$modelo,$patente,$precio){
        
        $this->marca= $marca;
        $this->modelo= $modelo;
        $this->patente = $patente;
        $this->precio= $precio;
    }

    public function save(){

        $autosList = getData(Self::$pathDataBase);
        $newIngreso = array(
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "patente" => $this->patente,
            "precio" => $this->precio,
        );
        saveData(Self::$pathDataBase,$newIngreso,$autosList);
        return $newIngreso;
    }

    public static function getAll(){
        $autosList = getData(Self::$pathDataBase);
        usort($autosList, function($a, $b){
            return strcmp( $a->tipo,$b->tipo);
        });
        return $autosList;
    }


    public static function getByPatente($patente){
        $autosList = getData(Self::$pathDataBase);
        $retorno = null;

        for ($i=0; $i < count($autosList); $i++) { 

            if($autosList[$i]->patente == $patente){                
                $retorno = $autosList[$i];
                break;
            }
        }
        return $retorno;
    }


}
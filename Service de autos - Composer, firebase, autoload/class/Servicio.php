<?php

class Servicio {
    
    private $id;
    private $tipo;
    private $precio;
    private $demora;

    public static $pathDataBase = "./data/tiposServicios.json";

    public function  __construct($id,$tipo,$precio,$demora){
        $this->id= $id;
        $this->tipo= $tipo;
        $this->precio= $precio;
        $this->demora= $demora;
    }

    public function save(){
        $servicioList = getData(Self::$pathDataBase);
        $newServicio = array(
            "id" => $this->id,
            "tipo" => $this->tipo,
            "precio" => $this->precio,
            "demora" => $this->demora
        );
        saveData(Self::$pathDataBase,$newServicio,$servicioList);
        return $newServicio;
    }
}
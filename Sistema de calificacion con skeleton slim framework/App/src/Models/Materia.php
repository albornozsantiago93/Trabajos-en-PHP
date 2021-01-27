<?php

namespace App\Models;
//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model {

    // protected $table = 'jugadores';
    // protected $primaryKey = 'flight_id';
    // public $incrementing = false;
    // protected $keyType = 'string';
    // public $timestamps = false;
    public $timestamps = false;
    protected $table= 'materias';
    protected $primaryKey= 'id';


    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
    
}
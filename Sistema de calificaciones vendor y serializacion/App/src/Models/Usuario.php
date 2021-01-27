<?php

namespace App\Models;
//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    // protected $table = 'jugadores';
    // protected $primaryKey = 'flight_id';
    // public $incrementing = false;
    // protected $keyType = 'string';
    // public $timestamps = false;
    public $timestamps = false;
    protected $table= 'usuarios';
    protected $primaryKey= 'id';


    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
    
}
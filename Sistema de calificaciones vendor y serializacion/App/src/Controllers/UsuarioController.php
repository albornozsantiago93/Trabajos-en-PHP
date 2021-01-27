<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\AlumnoMateria;
use Config\Database;
use Slim\Factory\Psr17\SlimPsr17Factory;

class AlumnoController {

    public function login(Request $request, Response $response, $args)
    {
        $body= $request->getParsedBody();

        if(!$this->validatePost(['email','clave','nombre','tipo'],$response))
        {
            return $response;
        }

        $user= Usuario::where('email','=',$body['email'])->where('clave','=',$body['clave'])->get()->first();

        if($user!= null){
            
            $rta= array('email'=> $user['email'],'nombre'=>$user['nombre'],'clave'=>$user['clave'],'tipo'=>$user['tipo']);
            $rta['token'] = $this->createJWT($rta);
            $response->getBody()->write(json_encode($rta));
            return $response->withStatus(200);
        }else{

            $response->getBody()->write("Usuario no registrado");
            return $response->withStatus(404);
        }
    }

    public function getAll (Request $request, Response $response, $args) {
        $rta = Usuario::get();

        echo($_POST['tipo']);
        $response->getBody()->write($rta);
        return $response;
    }

    public function getOne(Request $request, Response $response, $args)
    {
        $id= $args['id'];

        $rta = Usuario::find($id);

        if($rta!= null)
        {
            $response->getBody()->write(json_encode($rta));
            return $response;
        }else{
            $response->getBody()->write("User not found");
        }
    }


    public function getMaterias($id_materia)
    {
        $cupo= false;
        $materias= Materia::get();

        foreach($materias as $materia)
        {
            if($materia->cupos > 0 && $id_materia == $materia->id)
            {
                $materia->cupos --;
                $materia->save();
                $cupo= true;
            }
        }
        return $cupo;
    }

    public function getNotas(Request $request, Response $response, $args)
    {
        $id= $args['id'];

        $rta = AlumnoMateria::find($id);

        if($rta!= null)
        {
            $response->getBody()->write(json_encode($rta));
            return $response;
        }else{
            $response->getBody()->write("Notas not found");
        }
    }

    public function addAlumnoMateria(Request $request, Response $response, $args)
    {
        $idAlumno= $args['id'];
        $idMateria= $request->getParsedBody()['id_materia'];
        $respuesta= "error";
        
        $inscripcion= new AlumnoMateria;

        if($this->getMaterias($idMateria))
        {
            $inscripcion->id_alumno= $idAlumno;
            $inscripcion->id_materia= $idMateria;
            $inscripcion->save();
            $respuesta= "Alumno agregado";
        }
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
    public function getAllMaterias(Request $request, Response $response, $args)
    {
        $rta = Materia::get();

        $response->getBody()->write(json_encode( $rta));
        return $response;
    }

    public function postMateria(Request $request, Response $response, $args)
    {
        $body= $request->getParsedBody();

        
        if(!$this->validatePost(['nombre','cupos','cuatrimestre'],$response)){
            return $response;
        }

        $materia= new Materia;
        $materia->nombre= $body['nombre'];
        $materia->cupos= $body['cupos'];
        $materia->cuatrimestre= $body['cuatrimestre'];
        $rta= $materia->save();

        if($rta !=null)
        {           
            $response->getBody()->write(json_encode($rta));
            return $response;

        }else{

            $response->getBody()->write('error al crear materia');
            return $response->withStatus(500);
        }
        
    }

    public function addOne(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        if(!$this->validatePost(['nombre','clave','tipo','email'],$response)){
            return $response;
        }
        
        if(Usuario::where('email','=',$body['email'])->get()->first()!= null)
        {
            $response->getBody()->write("Usuario ya registrado");
            return $response->withStatus(404);
        }

        $user= new Usuario;
        $user->email= $body['email'];
        $user->clave= $body['clave'];
        $user->nombre= $body['nombre'];
        $user->tipo= $body['tipo'];

        if($user->save())
        {
            $rta= array('email'=> $body['email'], 'nombre'=> $body['nombre'], 'clave'=>$body['clave'],'tipo'=>$body['tipo']);
            $rta['token'] = $this->createJWT($rta);
            $response->getBody()->write(json_encode($rta));
            return $response->withStatus(201);            
        }
        else
        {
            $response->getBody()->write('error al crear usuario');
            return $response->withStatus(500);
        }
    }


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


    function validatePost($params,$response)
    {
        $retorno= true;

        for($i= 0 ; $i< count($params); $i++)
        {
            if(!isset($_POST[$params[$i]]))
            {
                $response->getBody()->write("El $params[$i] es necesario");
                $retorno= false;
                break;
            }
            return $retorno;
        }
    }

} 
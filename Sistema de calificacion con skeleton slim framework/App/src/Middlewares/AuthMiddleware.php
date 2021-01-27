<?php

namespace App\Middlewares;

use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Middlewares\AuthJWT;

//use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware
{
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
    
    //Recibe token por request y se fija si es valido
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $valido = false; // valido token, si el valor es correcto deja entrar
        $token= $_SERVER['HTTP_TOKEN'];        
        $payload = $this->validarJWT($token);

        //$rolEntrada= $request->getQueryParams()["rolUsuario"];//valido que los parametros de consulta        
        
        if($payload != null)
        {
            $valido= true;
        }

        if($valido){
            $response = $handler->handle($request);
            $content= (string)$response->getBody();
            $rta= new Response();
            $rta->getBody()->write($content);
            return $rta;

        }
        else {
            $response= new Response();
            $response->getBody()->write('Acceso denegado');
            return $response->withStatus(403);
        }        
    }

}

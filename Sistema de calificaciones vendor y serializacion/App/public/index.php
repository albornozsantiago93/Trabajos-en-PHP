<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Controllers\AlumnoController;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\AuthJWT;
use App\Models\Usuario;
use App\Models\Materia;
use Illuminate\Support\Facades\Auth;

require __DIR__ . '/../vendor/autoload.php';

$conn = new Database();
$app = AppFactory::create();
$app->setBasePath('/clase1/ParcialProgramacion/public');

$app->group('/users', function (RouteCollectorProxy $group) {
    
    $group->post('[/]', AlumnoController::class . ":addOne");
    
    $group->post('/login', AlumnoController::class . ":login");

    $group->post('/materia', AlumnoController::class . ":postMateria")->add(new AuthMiddleware);

    $group->get('/materias', AlumnoController::class . ":getAllMaterias")->add(new AuthMiddleware);      

    $group->post('/inscripcion/{id}', AlumnoController::class . ":addAlumnoMateria")->add(new AuthMiddleware);

    $group->get('/notas/{id}',AlumnoController::class . "getNotas");//->add(new AuthMiddleware);
    //$group->post('/inscripcion/{id}' AlumnoController::class . ":addAlumnoMateria")->add(new AuthMiddleware);
    /*
    $group->get('[/]', AlumnoController::class . ":getAll")->add(new AuthMiddleware);      
    
    $group->get('/{id}', AlumnoController::class . ":getOne");
    //update, no tenes en cuenta con put, error
    $group->post('/{id}', AlumnoController::class . ":updateOne");
    
    $group->delete('/{id}', AlumnoController::class . ":deleteOne");*/

    
})->add(new JsonMiddleware());

$app->addBodyParsingMiddleware();
$app->run();

?>
<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;
$router = new Router();

// login

$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

$router->post('/logout',[LoginController::class,'logout']);

// crear cuenta

$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);
// formulario olvide password

$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvde']);

// nuevo password
$router->get('/reestablecer',[LoginController::class,'reestablecer']);
$router->post('/reestablecer',[LoginController::class,'reestablecer']);

// confirmar cuenta
$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->get('/confirmar',[LoginController::class,'confirmar']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
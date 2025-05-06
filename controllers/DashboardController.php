<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){

        session_start();
        
        isAuth();
        $router->render('dashboard/index',[
            'titulo' => 'Proyectos'


        ]);
        

    }

    public static function crear_proyecto(Router $router){

        session_start();

        isAuth();
        $alertas = [];
       

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
   $proyecto = new Proyecto($_POST);
  
   $alertas = $proyecto->validarProyecto();

   if (empty($alertas)) {
    //debuguear($proyecto);
    // url unica
    $hash = bin2hex(random_bytes(16));
    $proyecto->url = $hash;
    // alamacenar id 
    $proyecto->propietarioId = $_SESSION['id'];

    $proyecto->guardar();

    header('Location:'.BASE_URL.'proyecto?id='. $proyecto->url);
    //debuguear($proyecto);
   }
}


        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'Crear Proyectos',
            'alertas' => $alertas
            

        ]);
        

    }

    public static function perfil(Router $router){

        session_start();

        isAuth();
        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil'


        ]);
        

    }

    public static function proyecto(Router $router){

session_start();
isAuth();

//debuguear($_SESSION);

$token = $_GET['id'];
//debuguear($token);
if (!$token) {
header('Location:'.BASE_URL.'dashboard');

}

$proyecto = Proyecto::where('url',$token);
//debuguear($proyecto);

if ($proyecto->propietarioId !== $_SESSION['id']) {
    header('Location:'.BASE_URL.'dashboard');
}

        $router->render('dashboard/proyecto',[
            'titulo' => $proyecto->proyecto
        ]);
    }
}
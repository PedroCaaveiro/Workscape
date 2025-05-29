<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){

        session_start();
        
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioID',$id);

       // debuguear($proyectos);

        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos


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
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        //debuguear($usuario);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        
            $usuario->sincronizar($_POST);
           $alertas = $usuario->validarPerfil();
           

            
           // debuguear($usuario);
           if (empty($alertas)) {

            $existeUsuario = Usuario::where('email',$usuario->email);

            if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                Usuario::setAlerta('error','Email no valido, ya pertenece a otra cuenta');
                $alertas = $usuario->getAlertas();
            }else{
            $usuario->guardar();
            Usuario::setAlerta('exito','Guardado correctamente');
            $alertas = $usuario->getAlertas();
            $_SESSION['nombre'] = $usuario->nombre;
            }

           
           }
        }
       
        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas


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

public static function cambiar_password(Router $router){
    session_start();
    isAuth();
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = Usuario::find($_SESSION['id']);
        $usuario->sincronizar($_POST);

        $alertas = $usuario->nuevoPassword(); 

        if (empty($alertas)) {
            $resultado = $usuario->comprobarPassword(); // Verifica si la contraseña actual es correcta

            if ($resultado) {
                // La contraseña actual es correcta, actualizamos la nueva contraseña
                $usuario->password = $usuario->nuevo_password;
                $usuario->limpiarPasswordActual(); 
                $usuario->hashearPassword();
                $usuario->guardar();

                Usuario::setAlerta('exito', 'Password guardado correctamente');
            } else {
                // Contraseña incorrecta
                Usuario::setAlerta('error', 'Password incorrecto');
            }

            $alertas = $usuario->getAlertas(); // Obtener las alertas (ya sean de éxito o error)
        }
    }

    $router->render('dashboard/cambiar-password', [
        'titulo' => 'Cambiar Password',
        'alertas' => $alertas
    ]);
}

}
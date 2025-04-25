<?php

namespace Controllers;

use MVC\Router; 
use Model\Usuario;


class LoginController{
public static function login(Router $router){

   // echo 'desde login';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }
    $router->render('auth/login',[
        'titulo'=> 'Iniciar Sesión'
    ]);
}


public static function logout(){

    echo 'desde logout';

    
}

public static function crear(Router $router){

   // echo 'desde crear';

   $usuario = new Usuario;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }

    $router->render('auth/crear',[
        'titulo' => 'Crear Cuenta en Workspace',
        'usuario' => $usuario
    ]);
}

public static function olvide(Router $router){

    //echo 'desde olvide';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }

    $router->render('auth/olvide',[
        'titulo' => 'Olvide mi password'
    ]);
}

public static function reestablecer(Router $router){

    //echo 'desde reestablecer';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }
    $router->render('auth/reestablecer',[
        'titulo' => 'Reestablecer Password'
    ]);
}

public static function mensaje(Router $router){

    //echo 'desde mensaje';

    $router->render('auth/mensaje',[
        'titulo'=> 'Cuenta creada Correctamente'
    ]);

   
}
public static function confirmar(Router $router){

    //echo 'desde confimar';

    $router->render('auth/confirmar',[
        'titulo' => 'Confirma tu cuenta en Workspace'
    ]);
}

}



?>
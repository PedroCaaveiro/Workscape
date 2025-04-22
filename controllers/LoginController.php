<?php

namespace Controllers;

use MVC\Router; 


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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }

    $router->render('auth/crear',[
        'titulo' => 'Crear Cuenta'
    ]);
}

public static function olvide(){

    echo 'desde olvide';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }
}

public static function reestablecer(){

    echo 'desde reestablecer';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        # code...
    }
}

public static function mensaje(){

    echo 'desde mensaje';

   
}
public static function confirmar(){

    echo 'desde confimar';

    
}

}



?>
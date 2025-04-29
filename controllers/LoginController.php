<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
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
    $alertas = [];
   $usuario = new Usuario;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $usuario->sincronizar($_POST);
       $alertas = $usuario->validarNuevaCuenta();
      // debuguear($usuario);
       //debuguear($alertas);

        if (empty($alertas)) {
            $existeUsuario = Usuario::where('email',$usuario->email);
            // debuguear($existeUsuario);
            if ($existeUsuario) {
              Usuario::setAlerta('error', 'El usuario ya esta registrado');
              $alertas = Usuario::getAlertas();
            }else{
                $usuario->hashearPassword();
                $password2 = $usuario->getPassword2();
                unset($password2);

                $usuario->generarToken();

                $usuario->confirmado = 0;
                
                //debuguear($usuario);

                $resultado = $usuario->guardar();

                $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                //debuguear($email);
                $email->enviarConfirmacion();
                
                if ($resultado) {
                    header('Location:'.BASE_URL.'/mensaje');
                    exit;
                }
                
            }
        }
      
    }

    $router->render('auth/crear',[
        'titulo' => 'Crear Cuenta en Workspace',
        'usuario' => $usuario,
        'alertas' => $alertas
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

    $token = s($_GET['token']);

    if (!$token) {
       header('Location:'.BASE_URL);
    }

    $usuario = Usuario::where('token',$token);

    if (empty($usuario)) {
        Usuario::setAlerta('error','Token no válido');
    }else{
        $usuario->confirmado = 1;
        $usuario->token = $usuario->token ?? '';
        $usuario->password2 = $usuario->password2 ?? '';

        $usuario->guardar();
        Usuario::setAlerta('exito','Cuenta comprobada correctamente');
        //debuguear($usuario);

    }
    $alertas = usuario::getAlertas();


    $router->render('auth/confirmar',[
        'titulo' => 'Confirma tu cuenta en Workspace',
        'alertas' => $alertas
    ]);
}

}



?>
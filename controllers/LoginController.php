<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use MVC\Router;
use Model\Usuario;


class LoginController
{
    public static function login(Router $router)
    {
     

        // echo 'desde login';

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuario::where('email',$usuario->email);
                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }else{

                    if (password_verify($_POST['password'],$usuario->password)) {
                      //  debuguear('correcto');
                      session_start();
                      $_SESSION['id'] = $usuario->id;
                      $_SESSION['nombre'] = $usuario->nombre;
                      $_SESSION['email'] = $usuario->email;
                      $_SESSION['login'] = true;
                     header('Location:'.BASE_URL.'dashboard');
                      
                    }else{
                      //  debuguear('incorrecto');
                      Usuario::setAlerta('error','El usuario no existe o no esta confirmado');

                    }                    
                }
            }
           // debuguear($usuario);

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }


    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location:'. BASE_URL);
    }

    public static function crear(Router $router)
    {

        // echo 'desde crear';
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            // debuguear($usuario);
            //debuguear($alertas);

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                // debuguear($existeUsuario);
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashearPassword();
                    $password2 = $usuario->getPassword2();
                    unset($password2);

                   $usuario->generarToken();

                    $usuario->confirmado = 0;

                    //debuguear($usuario);

                    $resultado = $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    //debuguear($email);
                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location:' . BASE_URL . '/mensaje');
                        exit;
                    }
                }
            }
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta en Workspace',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router)
    {

        //echo 'desde olvide';

        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                
                $usuarioDB = Usuario::where('email', $usuario->email);
               // var_dump($usuarioDB);
               // var_dump(method_exists($usuarioDB, 'generarToken')); 


              
                if ($usuarioDB && $usuarioDB->confirmado) {
                   // debuguear('si existe el usuario');
                  $usuarioDB->generarToken();
                
                   $password2 = $usuario->getPassword2();
                   unset($password2);
                    $usuarioDB->guardar();
                    
                    $email = new Email($usuarioDB->email,$usuarioDB->nombre,$usuarioDB->token);

                    $email->reestrablecerPassword();

                    Usuario::setAlerta('exito','Se ha enviado correctamente las instrucciones a su email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    
                }
            }
           
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router)
    {

        $token = s($_GET['token']);

        //debuguear($token);
        $alertas = [];
        $mostrar = true;
        $usuario = new Usuario;
       
        if (!$token) {
            header('Location:'.BASE_URL);
        }

        $usuario = Usuario::where('token',$token);
        // var_dump($usuario);
        if (empty($usuario)) {
            Usuario::setAlerta('error','token no valido');
            $alertas = Usuario::getAlertas();
            $mostrar = false;
        }        
        //echo 'desde reestablecer';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //var_dump($_POST); 
            
            $usuario->sincronizar(['password' => $_POST['password']]);


          $alertas = $usuario->validarPassword();

         if (empty($alertas)) {
            $usuario->hashearPassword();
            $usuario->token = null;
           // debuguear($usuario);
            $resultado = $usuario->guardar();

           if ($resultado) {
                header('Location:'.BASE_URL);
            }
           //debuguear($usuario);
         }

       

        }
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar'=> $mostrar
        ]);
    }

    public static function mensaje(Router $router)
    {

        //echo 'desde mensaje';
        $alertas = Usuario::getAlertas();
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada Correctamente'
            
        ]);
    }
    public static function confirmar(Router $router)
    {

        //echo 'desde confimar';

        $token = s($_GET['token']);

        if (!$token) {
            header('Location:' . BASE_URL);
        }

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = $usuario->token ?? '';
            $usuario->password2 = $usuario->password2 ?? '';

            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
            //debuguear($usuario);

        }
        $alertas = usuario::getAlertas();


        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta en Workspace',
            'alertas' => $alertas
        ]);
    }
}

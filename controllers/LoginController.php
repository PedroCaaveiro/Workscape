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
                      
                      session_start();
                      $_SESSION['id'] = $usuario->id;
                      $_SESSION['nombre'] = $usuario->nombre;
                      $_SESSION['email'] = $usuario->email;
                      $_SESSION['login'] = true;
                     header('Location:'.BASE_URL.'dashboard');
                      
                    }else{
                      
                      Usuario::setAlerta('error','El usuario no existe o no esta confirmado');

                    }                    
                }
            }
           

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

        
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
           

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashearPassword();
                    $password2 = $usuario->getPassword2();
                    unset($password2);

                   $usuario->generarToken();

                    $usuario->confirmado = 0;

                    

                    $resultado = $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    
                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location:' . BASE_URL . 'mensaje');
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

       

        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                
                $usuarioDB = Usuario::where('email', $usuario->email);
               


              
                if ($usuarioDB && $usuarioDB->confirmado) {
                 
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

       
        $alertas = [];
        $mostrar = true;
        $usuario = new Usuario;
       
        if (!$token) {
            header('Location:'.BASE_URL);
        }

        $usuario = Usuario::where('token',$token);
        
        if (empty($usuario)) {
            Usuario::setAlerta('error','token no valido');
            $alertas = Usuario::getAlertas();
            $mostrar = false;
        }        
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            
            $usuario->sincronizar(['password' => $_POST['password']]);


          $alertas = $usuario->validarPassword();

         if (empty($alertas)) {
            $usuario->hashearPassword();
            $usuario->token = null;
           
            $resultado = $usuario->guardar();

           if ($resultado) {
                header('Location:'.BASE_URL);
            }
           
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

      
        $alertas = Usuario::getAlertas();
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada Correctamente'
            
        ]);
    }
    public static function confirmar(Router $router)
    {

       

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
            

        }
        $alertas = usuario::getAlertas();


        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta en Workspace',
            'alertas' => $alertas
        ]);
    }
}

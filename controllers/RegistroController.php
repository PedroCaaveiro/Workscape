<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Model\Paquete;
use Model\Usuario;
use Model\Hora;
use Model\Dia;
use Model\Ponente;
use Model\Evento;
use Model\Categoria;
use Model\Regalo;
use Model\EventosRegistros;



class RegistroController {

    public static function crear (Router $router) {

        if (!isAuth()) {
            header('Location:'.BASE_URL);
        }
        $registro = Registro::where('usuario_id',$_SESSION['id']);

       /* if (isset($registro) && $registro->paquete_id ==="3") {
            header('Location:'. BASE_URL. 'boleto?id='. urlencode($registro->token));
        }*/
        $router->render('registro/crear',[
            'titulo' => 'Finalizar Registro',
            'registro' => $registro
        ]);

    }

       public static function gratis (Router $router) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

           
            if (!isAuth()) {
                header('Location:'.BASE_URL.'login');
            }
        $registro = Registro::where('usuario_id',$_SESSION['id']);

        if (isset($registro) && $registro->paquete_id ==="3") {
            header('Location:'. BASE_URL. 'boleto?id='. urlencode($registro->token));
        }

            $token = substr(uniqid(rand(),true),0,8);
            
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );
            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado){
             header('Location:'.BASE_URL.'boleto?id='. urlencode($registro->token));
            }
        }
    }

      public static function boleto (Router $router) {


            $id = $_GET['id'];
            if (!$id || strlen($id) !== 8) {
                session_start();
                 session_unset();
                 session_destroy();
                 header('Location:'.BASE_URL);
                  exit;
                
            }

            $registro = Registro::where('token',$id);
            if (!$registro) {
                session_start();
                 session_unset();
                 session_destroy();
                header('Location:'.BASE_URL);
                 exit;
            }

            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);

            
       
        $router->render('registro/boleto',[
            'titulo'=> 'Asistencia a Meetpilot',
            'registro' => $registro

        ]);
    }
 public static function pagar (Router $router) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isAuth()) {
            header('Location:'.BASE_URL.'login');
            exit;
        }

        if (empty($_POST)) {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        $datos = $_POST;


          if (isset($datos['regalo_id']) && $datos['regalo_id'] === '') {
            $datos['regalo_id'] = null;
        }

        $datos['token'] = substr(uniqid(rand(),true),0,8);
        $datos['usuario_id'] = $_SESSION['id'];

        try {
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            header('Content-Type: application/json');
          echo json_encode([
    'resultado' => $resultado ? 'ok' : 'error',
    'token' => $registro->token
]);


            exit;
        } catch (\Throwable $th) {
            header('Content-Type: application/json');
            echo json_encode([
                'resultado' => 'error',
                'mensaje' => $th->getMessage()
            ]);
            exit;
        }
    }
}

public static function conferencias(Router $router) {

    if (!isAuth()) {
        header('Location:' . BASE_URL . 'login');
        exit;
    }

    $usuario_id = $_SESSION['id'];
    // No usamos aquí Registro::where() porque vamos a filtrar más abajo
    // $registro = Registro::where('usuario_id', $usuario_id);


    if (isset($registro->regalo_id)) {
       header('Location:'.BASE_URL.'boleto?id='. urlencode($registro->token));
       exit;
    }

    $eventos = Evento::ordenar('hora_id', 'ASC');
    $eventos_formateados = [];

    foreach ($eventos as $evento) {
        $evento->categoria = Categoria::find($evento->categoria_id);
        $evento->dia = Dia::find($evento->dia_id);
        $evento->hora = Hora::find($evento->hora_id);
        $evento->ponente = Ponente::find($evento->ponente_id);

        if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
            $eventos_formateados['conferencias_v'][] = $evento;
        }

        if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
            $eventos_formateados['conferencias_s'][] = $evento;
        }

        if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
            $eventos_formateados['workshops_v'][] = $evento;
        }

        if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
            $eventos_formateados['workshops_s'][] = $evento;
        }
    }

    $regalos = Regalo::all('ASC');

    // Aquí obtenemos el registro correcto filtrando por usuario y paquete_id = 1, ordenado por id DESC y tomando el primero
    $registros = Registro::whereArray(['usuario_id' => $usuario_id, 'paquete_id' => 1], 'ORDER BY id DESC LIMIT 1');
    $registro = $registros[0] ?? null;

    if (!$registro || !in_array($registro->paquete_id, ['1', '2', '3'])) {
        header('Location:' . BASE_URL);
        exit;
    }

    // Obtener eventos ya seleccionados por el usuario
    $eventos_usuario = EventosRegistros::whereArray(['registro_id' => $registro->id]);
    $eventos_seleccionados = array_map(fn($e) => $e->evento_id, $eventos_usuario);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        header('Content-Type: application/json');

        if (!isAuth()) {
            header('Location:' . BASE_URL . 'login');
            exit;
        }

        $eventos = $_POST['eventos'] ?? [];

        if (empty($eventos)) {
            echo json_encode(['resultado' => false, 'mensaje' => 'No se enviaron eventos']);
            exit;
        }

        // Reconfirmamos el registro en POST también
        $registros = Registro::whereArray(['usuario_id' => $_SESSION['id'], 'paquete_id' => 1], 'ORDER BY id DESC LIMIT 1');
        $registro = $registros[0] ?? null;

        if (!$registro || !in_array($registro->paquete_id, ['1', '2', '3'])) {
            header('Location:' . BASE_URL);
            exit;
        }

        // Contar cuántos eventos ya tiene el usuario registrados
        $eventos_existentes = EventosRegistros::whereArray(['registro_id' => $registro->id]);
        $cantidad_actual = count($eventos_existentes);
        $cantidad_nuevos = count($eventos);

        if ($cantidad_actual + $cantidad_nuevos > 5) {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'Ya has registrado ' . $cantidad_actual . ' eventos. Solo puedes seleccionar hasta 5 en total.'
            ]);
            exit;
        }

        $eventos_array = [];

        foreach ($eventos as $evento_id) {
            $evento = Evento::find($evento_id);

            if (!isset($evento) || $evento->disponibles === null || $evento->disponibles <= 0) {
                echo json_encode(['resultado' => false, 'mensaje' => 'Evento no disponible o inválido']);
                exit;
            }

            $eventos_array[] = $evento;
        }

        foreach ($eventos_array as $evento) {
            $evento->disponibles -= 1;
            $evento->guardar();

            $datos = [
                'evento_id' => (int) $evento->id,
                'registro_id' => (int) $registro->id
            ];
            $registro_usuario = new EventosRegistros($datos);
            $registro_usuario->guardar();
        }

        $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
        $resultado = $registro->guardar();

        if ($resultado) {
           echo json_encode([
                'resultado' => 'ok',
                'token' => $registro->token  
            ]);
        } else {
            echo json_encode(['resultado' => false, 'mensaje' => 'Error al guardar registro']);
        }
        exit;
    }

    $router->render('registro/conferencias', [
        'titulo' => 'Elige Workhops & Conferencias',
        'eventos' => $eventos_formateados,
        'regalos' => $regalos,
        'eventos_seleccionados' => $eventos_seleccionados
    ]);
}



}
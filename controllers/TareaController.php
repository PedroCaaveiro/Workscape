<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController
{

    public static function index() {}

    public static function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);
          //  var_dump($proyecto->id);
            

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al añadir una tarea'

                ];
                echo json_encode($respuesta);
                return;
            } 
           
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

             // debuguear($_POST);
              // var_dump($tarea->proyectoId);
                $resultado = $tarea->guardar();
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $resultado['id'],
                    'mensaje' => 'Tearea creada correctamente'
                ];
               

                echo json_encode($respuesta);
              

           
        }
    }

    public static function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}

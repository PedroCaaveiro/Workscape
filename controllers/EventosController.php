<?php

namespace Controllers;



use MVC\Router;
use Model\Categoria;
use Model\Ponente;
use Model\Dia;
use Model\Hora;
use Model\Evento;
use Classes\Paginacion;


class EventosController{

public static function index(Router $router){
$paginaActual = $_GET['page'];
$paginaActual = filter_var($paginaActual,FILTER_VALIDATE_INT);

if (!$paginaActual || $paginaActual <1) {
    header('Location:' .BASE_URL . 'admin/eventos?page=1');
}

$por_pagina = 10;
$total = Evento::total();
$paginacion = new Paginacion($paginaActual,$por_pagina,$total);

$eventos = Evento::paginar($por_pagina,$paginacion->offset());  

foreach($eventos as $evento){
    $evento->categoria = Categoria::find($evento->categoria_id);
    $evento->dia = Dia::find($evento->dia_id);
    $evento->hora = Hora::find($evento->hora_id);
    $evento->ponente = Ponente::find($evento->ponente_id);
}

$router->render('admin/eventos/index',[
    'titulo'=> 'Conferencias & Workshops',
    'eventos' => $eventos,
    'paginacion' => $paginacion

]);
}


public static function crear(Router $router){

   $alertas =[];

$categorias = Categoria::all('ASC');
$dias = Dia::all('ASC');
$horas = Hora::all('ASC');

$evento = new Evento();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

    $evento->sincronizar($_POST);
    $alertas = $evento->validar();
    if (empty($alertas)) {
        $resultado = $evento->guardar();

        if ($resultado) {
            header('Location:'.BASE_URL. 'admin/eventos');
        }
    }
}


$router->render('admin/eventos/crear',[
    'titulo'=> 'Registrar Eventos',
    'alertas' => $alertas,
    'categorias' => $categorias,
    'dias' => $dias,
    'horas' => $horas,
    'evento' =>$evento

]);
}


public static function editar(Router $router){

   $alertas =[];

   $id = $_GET['id'];

   $id = filter_var($id,FILTER_VALIDATE_INT);

   if (!$id) {
    header('Location:'. BASE_URL . 'admin/eventos');
   }

$categorias = Categoria::all('ASC');
$dias = Dia::all('ASC');
$horas = Hora::all('ASC');

$evento = Evento::find($id);

if (!$evento) {
    header('Location:' . BASE_URL. 'admin/eventos');
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

    $evento->sincronizar($_POST);
    $alertas = $evento->validar();
    if (empty($alertas)) {
        $resultado = $evento->guardar();

        if ($resultado) {
            header('Location:'.BASE_URL. 'admin/eventos');
        }
    }
}


$router->render('admin/eventos/editar',[
    'titulo'=> 'Editar Eventos',
    'alertas' => $alertas,
    'categorias' => $categorias,
    'dias' => $dias,
    'horas' => $horas,
    'evento' =>$evento

]);
}



    public static function eliminar(Router $router){



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

         $id = trim($_POST['id']);

            $evento = Evento::find($id);

if (!$evento) {
    header('Location:'.BASE_URL. 'admin/eventos');
    exit;
}

            $resultado = $evento->eliminar();

            if ($resultado) {
                 header('Location:'.BASE_URL. 'admin/eventos');
                 exit;
            }
          
        }

       


    }

}




?>
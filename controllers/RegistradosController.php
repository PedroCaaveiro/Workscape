<?php

namespace Controllers;



use MVC\Router;
Use Model\Registro;
use Model\Ponente;
use Classes\Paginacion;
use Model\Usuario;
use Model\Paquete;



class RegistradosController{

public static function index(Router $router){

if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}


   $alertas = [];
$ponentes = Ponente::all();

$pagina_actual = $_GET['page'];
$pagina_actual = filter_var($pagina_actual,FILTER_VALIDATE_INT);

if (!$pagina_actual || $pagina_actual < 1 ) {
    header('Location:'.BASE_URL. 'admin/registrados?page=1');
    exit;
}


$registros_X_pagina =5;
$total_registros = Registro::total();
$paginacion = new Paginacion($pagina_actual,$registros_X_pagina,$total_registros);
$registros = Registro::paginar($registros_X_pagina,$paginacion->offset());
foreach($registros as $registro){
foreach ($registros as $registro) {
    $registro->usuario = !empty($registro->usuario_id) ? Usuario::find($registro->usuario_id) : null;
    $registro->paquete = !empty($registro->paquete_id) ? Paquete::find($registro->paquete_id) : null;
}


}



if ($paginacion->total_paginas() < $pagina_actual) {
   header('Location:'.BASE_URL. 'admin/registrados?page=1');
    exit;
}

$router->render('admin/registrados/index',[
    'titulo'=> 'Usuarios Registrados',
    'registros' => $registros,
    'paginacion' => $paginacion

]);
}

}




?>
<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router) {

                if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}
$alertas = [];
$ponentes = Ponente::all();

$pagina_actual = $_GET['page'];
$pagina_actual = filter_var($pagina_actual,FILTER_VALIDATE_INT);

if (!$pagina_actual || $pagina_actual < 1 ) {
    header('Location:'.BASE_URL. 'admin/ponentes?page=1');
    exit;
}


$registros_X_pagina =5;
$total_registros = Ponente::total();
$paginacion = new Paginacion($pagina_actual,$registros_X_pagina,$total_registros);
$ponentes = Ponente::paginar($registros_X_pagina,$paginacion->offset());


if ($paginacion->total_paginas() < $pagina_actual) {
   header('Location:'.BASE_URL. 'admin/ponentes?page=1');
    exit;
}



if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}



 if (isset($_GET['creado']) && $_GET['creado'] == '1') {
        $alertas['exito'][] = 'Ponente creado correctamente.';
    }
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencias',
            'alertas' => $alertas,
            'ponentes'=>$ponentes,
            'paginacion' =>$paginacion
        ]);
    }

    public static function crear(Router $router) {
        $alertas = [];
        $ponente = new Ponente;

        if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}
            if (!empty($_FILES['imagen']['tmp_name'])) {
   $carpeta_imagenes = __DIR__ . '/../public/build/img/speakers';


    if (!is_dir($carpeta_imagenes)) {
        mkdir($carpeta_imagenes, 0755, true);
    }

    $nombre_imagen = md5(uniqid(rand(), true));

    try {
        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800);

        $imagen_png = clone $image;
        $imagen_webp = clone $image;
        $imagen_avif = clone $image;

        $imagen_png->encode('png', 80);
        $imagen_webp->encode('webp', 80);
        $imagen_avif->encode('avif', 80);

        $_POST['imagen'] = $nombre_imagen;
    } catch (\Exception $e) {
        $alertas[] = 'Error al procesar la imagen.';
    }
}

if (isset($_POST['redes']) && is_array($_POST['redes'])) {
        $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
    }


            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if (empty($alertas)) {
                if (isset($imagen_png, $imagen_webp, $imagen_avif)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                   
                }

              $resultado = $ponente->guardar();

              if ($resultado) {
               header('Location: ' . BASE_URL . 'admin/ponentes?creado=1');
                exit;

              }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router){

        $alertas = [];
       
        $id = $_GET['id'] ?? null;
        $id = filter_var($id,FILTER_VALIDATE_INT);

        if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}
        

        if (!$id) {
            header('Location:'.BASE_URL.'/admin/ponentes');
            exit;
        }
        
        $ponente = Ponente::find($id);

        if (!$ponente) {
            header('Location:'. BASE_URL. 'admin/ponentes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

            if (!empty($_FILES['imagen']['tmp_name'])) {
   $carpeta_imagenes = __DIR__ . '/../public/build/img/speakers';


    if (!is_dir($carpeta_imagenes)) {
        mkdir($carpeta_imagenes, 0755, true);
    }

    $nombre_imagen = md5(uniqid(rand(), true));

    try {
        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800);

        $imagen_png = clone $image;
        $imagen_webp = clone $image;
        $imagen_avif = clone $image;

        $imagen_png->encode('png', 80);
        $imagen_webp->encode('webp', 80);
        $imagen_avif->encode('avif', 80);

        $_POST['imagen'] = $nombre_imagen;
    } catch (\Exception $e) {
        $alertas[] = 'Error al procesar la imagen.';
    }
}else{
    $_POST['imagen'] = $ponente->imagen_actual;
}
 $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
$ponente->sincronizar($_POST);

$alertas = $ponente->validar();

if (empty($alertas)) {
   if (isset($nombre_imagen)) {
                     $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                }

                $resultado = $ponente->guardar();
                if ($resultado) {
                    header('Location:'. BASE_URL.'admin/ponentes');
                    exit;
                }
}

        }
        
        
        $router->render('admin/ponentes/editar',[
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        
        ]);

    }

    public static function eliminar(Router $router){

   

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     if (!isAdmin()) {
    header('Location:'.BASE_URL.'login');
    exit;
}

         $id = trim($_POST['id']);
            $ponente = Ponente::find($id);
if (!$ponente) {
    header('Location:'.BASE_URL. 'admin/ponentes');
    exit;
}

            $resultado = $ponente->eliminar();

            if ($resultado) {
                 header('Location:'.BASE_URL. 'admin/ponentes');
                 exit;
            }
          
        }

       


    }
}

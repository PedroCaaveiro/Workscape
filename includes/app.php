<?php 

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocalhost = ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0);

// depurar
//echo 'Localhost: ' . ($isLocalhost ? 'si' : 'no') . '<br>';

// Definir la URL base correctamente para el entorno local
$isLocalhost = $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1';

// URL base para rutas (controlador)
$base = $isLocalhost
    ? 'http://localhost/Workscape/public/index.php/'
    : 'http://workspace.infinityfree.me/';

// URL base para recursos estáticos (CSS, JS, imágenes)
$baseAssets = $isLocalhost
    ? 'http://localhost/Workscape/public/'
    : 'https://midominio.com/';

define('BASE_URL', $base);
define('ASSETS_URL', $baseAssets);






require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);
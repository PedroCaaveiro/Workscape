<?php 

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$isLocalhost = ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0);

// URL base para rutas (controlador)
$base = $isLocalhost
    ? 'http://127.0.0.1:3000/index.php/' 
    : 'https://proyectospedro.42web.io/Workscape/public/index.php/';

// URL base para recursos estáticos (CSS, JS, imágenes)
$baseAssets = $isLocalhost
    ? 'http://127.0.0.1:3000/'     
    : 'https://proyectospedro.42web.io/Workscape/public/';

define('BASE_URL', $base);
define('ASSETS_URL', $baseAssets);

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

<?php 

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$isLocalhost = ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0);

// URL base para rutas (controlador)
$base = $isLocalhost
    ? 'http://localhost/Workscape/public/index.php/'
    : 'https://proyectospedro.42web.io/public/index.php/';

// URL base para recursos estáticos (CSS, JS, imágenes)
$baseAssets = $isLocalhost
    ? 'http://localhost/Workscape/public/'
    : 'https://proyectospedro.42web.io/public/';

define('BASE_URL', $base);
define('ASSETS_URL', $baseAssets);

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

<?php 

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocalhost = ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0);

// depurar
//echo 'Localhost: ' . ($isLocalhost ? 'si' : 'no') . '<br>';

// Definir la URL base correctamente para el entorno local
$base = $isLocalhost ? 'http://127.0.0.1:3000/' : 'https://midominio.com/';
define('BASE_URL', $base);




require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);
<?php

$db = mysqli_connect('sql313.infinityfree.com', 'if0_38503538', 'Caaveiro2025', 'if0_38503538_Workspace');

if (!$db) {
  //  echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

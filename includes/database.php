<?php

<<<<<<< HEAD
//$db = mysqli_connect('sql313.infinityfree.com', 'if0_38503538', 'Caaveiro2025', 'if0_38503538_Workspace');

=======
>>>>>>> b5724c58a4c3b3e21ac7cd8cdf027fea87f8971e
$db = mysqli_connect('localhost', 'root', 'root', 'workscape');

if (!$db) {
  //  echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

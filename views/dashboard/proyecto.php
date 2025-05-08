
<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button class="agregar-tarea" id="agregar-tarea" type="button">&#43;Nueva Tarea</button>
    </div>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>

<script>
  const baseUrl = '<?php echo BASE_URL; ?>'; // Inyectamos el valor de BASE_URL de PHP
  
</script>

<?php

$script = '<script src="' . BASE_URL . 'build/js/tareas.js"></script>';

?>

<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button class="agregar-tarea" id="agregar-tarea" type="button">&#43;Nueva Tarea</button>
    </div>
 <div class="filtros" id="filtros">
 
   

    <div class="filtros-inputs">
       <h2>Filtros:</h2>
      <div class="campo">
        <label for="todas">Todas</label>
        <input type="radio" name="filtro" id="todas" value="" checked>
      </div>
      <div class="campo">
        <label for="completadas">Completadas</label>
        <input type="radio" name="filtro" id="completadas" value="1">
      </div>
      <div class="campo">
        <label for="Pendientes">Pendientes</label>
        <input type="radio" name="filtro" id="pendientes" value="0">
      </div>
    </div>
  
</div>


    <ul id="listado-tareas" class="listado-tareas"></ul>
    
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>

<script>
  const baseUrl = '<?php echo BASE_URL; ?>'; 
  
</script>

<?php

$script  .= '<script src="' . ASSETS_URL . 'build/js/tareas.js"></script>';
$script .= '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';


?>
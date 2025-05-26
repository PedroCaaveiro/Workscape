<aside class="sidebar">
<div class="contenedor-sidebar">
<h2>Workspace</h2>
 <div class="cerrar-menu">
        <img src="build/cerrar.svg" alt="" id="cerrar-menu" alt='imagen menu'>
    </div>

</div>    



<div class="sidebar-nav">
    <a class= "<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="<?= BASE_URL.'dashboard' ?>">Proyectos</a>
    <a class= "<?php echo ($titulo === 'Crear Proyectos') ? 'activo' : ''; ?>" href="<?= BASE_URL.'crear-proyecto' ?>">Crear Proyectos</a>
    <a class= "<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="<?= BASE_URL.'perfil' ?>">Perfil</a>

</div>

<div class="cerrar-sesion-mobile">
      <a  class='cerrar-sesion' href="<?= BASE_URL.'logout' ?>">Cerrar Sesión</a>
</div>

</aside>
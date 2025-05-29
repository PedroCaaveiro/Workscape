
<?php include_once __DIR__ . '/header-dashboard.php' ?>


<div class="contenedor-sm">
  <?php include_once __DIR__.'/../templates/alertas.php';?>
  
<a  class='enlace' href="<?= BASE_URL.'cambiar-password' ?>">Cambiar Password</a>

<form action="<?php echo BASE_URL;?>perfil" class="formulario" method="POST">
<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $usuario->nombre;?>">
     
</div>
<div class="campo"><label for="email">Email</label>
    <input type="text"name="email" placeholder="Email"value="<?php echo $usuario->email;?>"></div>

    <input type="submit" value="Guardar Cambios">
</form>

</div>
<?php include_once __DIR__ . '/footer-dashboard.php' ?>
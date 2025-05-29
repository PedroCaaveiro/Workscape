
<?php include_once __DIR__ . '/header-dashboard.php' ?>


<div class="contenedor-sm">
  <?php include_once __DIR__.'/../templates/alertas.php';?>

   <a  class='enlace' href="<?= BASE_URL.'perfil' ?>">Volver a Perfil</a>

<form action="<?php echo BASE_URL;?>cambiar-password" class="formulario" method="POST">
<div class="campo">
    <label for="password_actual">Actual</label>
    <input type="password" name="password_actual" placeholder="Password Actual">
     
</div>
<div class="campo"><label for="nuevo_password">Nuevo</label>
    <input type="password"name="nuevo_password" placeholder="Password Nuevo"></div>

    <input type="submit" value="Guardar Cambios">
</form>

</div>
<?php include_once __DIR__ . '/footer-dashboard.php' ?>
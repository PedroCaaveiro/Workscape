
<div class="contenedor crear">
    
<?php include_once __DIR__. '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Crea tu cuenta Workspace</div>
        <?php include_once __DIR__. '/../templates/alertas.php';?>

        <form action="<?= BASE_URL ?>crear" class="formulario" method="POST">

        <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre"value="<?php echo $usuario->nombre;?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"value="<?php echo $usuario->email;?>">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input type="password" name="password2" id="password2">
            </div>
            <input type="submit" value="Crear Cuenta" class='boton'>

        </form>

        <div class="acciones">
           
            <a href="<?= BASE_URL ?>">Ya tienes cuenta? Inicia Sesión</a>
            <a href="<?= BASE_URL ?>olvide">Olvidaste tu Password?</a>

        </div>
    </div>
</div>
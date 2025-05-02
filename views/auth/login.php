
<?php


require_once __DIR__ . '/../../includes/app.php';  



?>


<div class="contenedor login">

<?php include_once __DIR__. '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Inicia Sesión en tu cuenta en Workspace</div>

        <?php include_once __DIR__. '/../templates/alertas.php';?>
        <form action="<?= BASE_URL ?>" class="formulario" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Escribe tu Email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Escribe tu Password">
            </div>
            <input type="submit" value="Iniciar Sesión" class='boton'>

        </form>

        <div class="acciones">
           
            <a href="<?= BASE_URL ?>crear">Creaste una cuenta? Créala!</a>
            <a href="<?= BASE_URL ?>olvide">Olvidaste tu Password?</a>

        </div>
    </div>
</div>
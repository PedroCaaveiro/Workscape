
<div class="contenedor olvide">

<?php include_once __DIR__. '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Recupera tu Password a Workspace</div>

        <?php include_once __DIR__. '/../templates/alertas.php';?>

        <form action="<?= BASE_URL ?>olvide" class="formulario" method="POST" novalidate>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

         
            <input type="submit" value="Enviar" class='boton'>

        </form>

        <div class="acciones">
           
            <a href="<?= BASE_URL ?>crear">Creaste una cuenta? Créala!</a>
            <a href="<?= BASE_URL ?>">Iniciar Sesión</a>

        </div>
    </div>
</div>
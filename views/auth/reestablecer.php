<div class="contenedor reestablecer">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Introduce tu nuevo Password</div>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php

        if ($mostrar) { ?>



            <form  class="formulario" method="POST">

                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Escribe tu Password">
                </div>


                <input type="submit" value="Guardar Password" class='boton'>

            </form>

        <?php } ?>

        <div class="acciones">

            <a href="<?= BASE_URL ?>/">Ya tienes cuenta? Inicia Sesión</a>
            <a href="<?= BASE_URL ?>olvide">Olvidaste tu Password?</a>

        </div>
    </div>
</div>
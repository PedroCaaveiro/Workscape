
<div class="contenedor crear">
    
<?php include_once __DIR__. '/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Iniciar Sesión</div>

        <form action="<?= BASE_URL ?>" class="formulario" method="POST">

        <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Escribe tu Nombre">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Escribe tu Email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Escribe tu Password">
            </div>

            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input type="password" name="password2" id="password2" placeholder="Repite tu Password">
            </div>
            <input type="submit" value="Iniciar Sesión" class='boton'>

        </form>

        <div class="acciones">
           
            <a href="<?= BASE_URL ?>/">Ya tienes cuenta? Inicia Sesión</a>
            <a href="<?= BASE_URL ?>olvide">Olvidaste tu Password?</a>

        </div>
    </div>
</div>
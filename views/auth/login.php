
<?php

// Asegúrate de que la ruta esté correcta según tu estructura de carpetas
require_once __DIR__ . '/../../includes/app.php';  // Ajustamos la ruta desde views/auth



?>



<div class="contenedor">
    <h1>Workscape</h1>
    <p>Crea y administra tus Proyectos</p>

    <div class="contenedor-sm">
        <div class="descripcion-pagina">Iniciar Sesión</div>

        <form action="<?= BASE_URL ?>" class="formulario" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email">
            </div>

            <div class="password">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <input type="submit" value="Iniciar Sesión" class='boton'>

        </form>

        <div class="acciones">
           
            <a href="<?= BASE_URL ?>crear">Creaste una cuenta? Créala!</a>
            <a href="<?= BASE_URL ?>olvide">Olvidaste tu Password?</a>

        </div>
    </div>
</div>
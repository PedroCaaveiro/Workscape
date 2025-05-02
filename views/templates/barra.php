<div class="barra">
    <p>Hola:
        <span><?php echo $_SESSION['nombre']; ?></span>
    </p>
    <a  class='cerrar-sesion' href="<?= BASE_URL.'logout' ?>">Cerrar Sesión</a>

</div>
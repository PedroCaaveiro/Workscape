<div class="barra-mobile">
    <h1>Workspace</h1>
    <div class="menu">
        <img src="build/menu.svg" alt="" id="mobile-menu" alt='imagen menu'>
    </div>
</div>


<div class="barra">
    <p>Hola:
        <span><?php echo $_SESSION['nombre']; ?></span>
    </p>
    <a  class='cerrar-sesion' href="<?= BASE_URL.'logout' ?>">Cerrar Sesión</a>

</div>
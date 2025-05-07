
<?php include_once __DIR__ . '/header-dashboard.php' ?>

<?php if (count($proyectos) === 0) { ?>
   <p class="no-proyectos">No hay proyectos aun <a href="<?php echo BASE_URL. 'crear-proyecto';?>">Comienza creando uno</a></p>
<?php } else {  ?>

<ul class="listado-proyectos">

<?php foreach($proyectos as $proyecto){ ?>

    <li class="proyecto">
    <a href="<?php echo BASE_URL . 'proyecto?id=' . $proyecto->url; ?>">

            <?php echo $proyecto->proyecto ?>
        </a>
    </li>
    <?php }?>
</ul>
    <?php }?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>
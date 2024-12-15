<a href="/servicios">
    <img src="/build/img/ArrowLeft.svg" alt="Atras">
</a>

<h1 class="nombre-pagina">Actulizar Servicio</h1>
<p class="descripcion-pagina">Modifica los campos del formulario</p>

<?php
    //include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario"> <!-- Cuando esta sin el action lo envia la url que ya tenemos -->
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" class="boton" value="Actualizar">
</form>
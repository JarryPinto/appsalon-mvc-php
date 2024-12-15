<a href="/admin">
    <img src="/build/img/ArrowLeft.svg" alt="Atras">
</a>

<h1 class="nombre-pagina">Agregar Nuevo Servicio</h1>
<p class="descripcion-pagina">Llena todos los campos para añadir el nuevo servicio</p>

<?php
    //include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" class="boton" value="Crear Servicio">
</form>
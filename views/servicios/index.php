<a href="/admin">
    <img src="/build/img/ArrowLeft.svg" alt="Atras">
</a>

<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php
    //include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php foreach($servicios as $servicio) { ?>
        <li>
            <div class="informacion">
                <p>Nombre: <span><?php echo $servicio->nombre; ?></span> </p>
                <p>Precio: <span>$<?php echo $servicio->precio; ?></span> </p>
            </div>

            <div class="acciones">
                <a href="/servicios/actualizar?id=<?php echo $servicio->id; ?>" class="boton">
                    <img src="/build/img/edit.svg" alt="Editar">
                </a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <button type="submit" class="boton-eliminar" aria-label="Eliminar">
                        <img src="/build/img/delete.svg" alt="Eliminar Servicio">
                    </button>
                </form>
            </div>
        </li>
    <?php } ?>
</ul>
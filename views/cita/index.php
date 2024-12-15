<h1 class="nombre-pagina">Genera tu Cita</h1>
<p class="descripcion-pagina">Selecciona los servicios que necesitas a continuación</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Datos y Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios">

        </div>
    </div>
    
    <div id="paso-2" class="seccion">
        <h2>Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input 
                    id="nombre"
                    type="text"
                    placeholder="Ingresa tu nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>

            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input 
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                />
            </div>

            <div class="campo">
                <label for="hora">Hora:</label>
                <input 
                    id="hora"
                    type="time"
                />
            </div>

            <input type="hidden" id="id" value="<?php echo $id;?>">
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información este correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">
            &laquo; Anterior <!-- El laquo pone como unas flechas hacia atras (left) -->
        </button>

        <button id="siguiente" class="boton">
            Siguiente &raquo; <!-- El raquo pone como unas flechas hacia adelante (raigh) -->
        </button>
    </div>

</div>

<?php 
    //Aqui definimosla variable script, con el js
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>  

        <script src='build/js/app.js'></script>
    ";
?>
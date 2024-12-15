<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha:</label>
            <input 
                type="date"     
                id="fecha" 
                name="fecha" 
                value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>

<?php 
    if (count($citas) === 0) {
        echo "<h2>No hay Citas Agendadas</h2>";
    }
?>

<div id="citas-admin">
    <ul class="citas">

        <?php 
            $idCita = 0;
            foreach($citas as $key => $cita) { 

                if ($idCita !== $cita->id) {
                    $total = 0; //Lo ponemos aqui porque lo va a reiniciar a cero cada ves que cambien de cita
                    //No lo va a reiniciar en cada interacion del foreach
            
        ?>
                    <li>
                        <p>ID: <span><?php echo $cita->id; ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                        <h3>Servicios</h3>
            <?php 
                $idCita = $cita->id;
                } //Fin del IF 
                $total += (int) str_replace('.', '', $cita->precio); // Remover puntos y convertir a número
            ?>
                        <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p>
                    <!-- el li dejamos que el html lo cierre automaticamente -->

                <?php
                    $actual = $cita->id; //Nos va a retornar el ID de la BD en el que nos encontramos
                    $proximo = $citas[$key + 1]->id ?? 0; //Este es el indice del arreglo de la BD

                    if (esUltimo($actual, $proximo)) {  
                ?>
                        <p class="total">Total: <span>$<?php echo number_format($total, 0, ',', '.'); ?></span></p>

                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>" >

                            <input type="submit" class="boton-eliminar" value="eliminar">
                        </form>
                <?php } 
            } //Fin del Foreach ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>"
?>
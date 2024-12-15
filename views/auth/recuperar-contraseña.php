<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Restablece una nueva contraseña acontinuacion.</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Ingresa tu nueva contraseña"
        />
    </div>

    <input type="submit" class="boton" value="Guardar nueva contraseña"/> 

</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún No tienes cuenta? Crea una</a>
</div>
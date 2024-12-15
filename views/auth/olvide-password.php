<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Restablece una nueva contraseña</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email:</label>  <!--E name es para leerlo con POST['name'] -->
        <input type="email" id="email" placeholder="Tuemail@email.com" name="email">  
    </div>

    <input type="submit" class="boton" value="Enviar Correo">
</form>

<div class="acciones">
    <a href="/">Ya tienes cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún No tienes cuenta? Crea una</a>
</div>


<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/">
    
    <div class="campo">
        <label for="email">Email:</label>  <!--E name es para leerlo con POST['name'] -->
        <input 
        type="email" 
        id="email" 
        placeholder="Tuemail@email.com" 
        name="email">  
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>  <!--E name es para leerlo con POST['name'] -->
        <input type="password" id="password" placeholder="Tu contraseña" name="password">  
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún No tienes cuenta? Crea una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>
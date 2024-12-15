<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu Nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu Apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ingresa tu Teléfono" value="<?php echo s($usuario->telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">Email:</label>  <!--E name es para leerlo con POST['name'] -->
        <input type="email" id="email" placeholder="Ingresa Tu correo" name="email" value="<?php echo s($usuario->email); ?>">  
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>  <!--E name es para leerlo con POST['name'] -->
        <input type="password" id="password" placeholder="Tu contraseña" name="password">  
    </div>

    <input type="submit" value="Crear Cuenta" class="boton"> 
</form>

<div class="acciones">
    <a href="/">Ya tienes cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>
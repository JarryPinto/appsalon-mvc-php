<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
$router = new Router();

use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\APIController;
use Controllers\ServicioController;

//ESTA ES LA PARTE DE LOS USUARIOS
//iniciar sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
//recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);
//crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);
//confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//AREA PRIVADA (Tener Cuenta)
//(USUARIO)
$router->get('/cita', [CitaController::class, 'index']);
//(ADMINISTRADOR)
$router->get('/admin', [AdminController::class, 'index']);
//CRUD de Servicios
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

//API de Citasx 
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']); //registrar nuevas citas en la base de datos
$router->get('/api/citas', [APIController::class, 'citas']); //MUestra las citas 
$router->post('/api/eliminar', [APIController::class, 'eliminar']);




// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
<?php 

namespace Controllers;

use MVC\Router;

class CitaController {

    public static function index(Router $router) {

        session_start(); //Va a arrancar la seccion de nuevo

        isAuth();

        $router->render('/cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }

}
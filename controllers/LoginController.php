<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    //Iniciar sesion
    public static function login(Router $router) {

        $alertas = [];

        //$auth = new Usuario; //Para almacenar lo que se ingreso posteriormente
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //Comprobamos que el usuario existe (Por medio del Email)}
                $usuario = Usuario::where('email', $auth->email);
                
                if ($usuario) {
                    //Verificamos el Password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        //Autenticamos a el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamos al usuario
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }
                        else {
                            header('Location: /cita');
                        }
                    }
                }
                else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('/auth/login', [
            'alertas' => $alertas
        ]);
    }


    //Cerrar sesion
    public static function logout() {
        session_start();

        $_SESSION = []; //Para vaciar la sesion 

        header('Location: /');
    }


    //Cuando olvida la contraseña
    public static function olvide(Router $router) {
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                //Para revisar si el usuario existe y ya esta confirmado
                if ($usuario && $usuario->confirmado === "1") {
                    //Generamos un token
                    $usuario->crearToken();
                    $usuario->guardar(); //Para que le agregue el token al usuario (update)

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Correo enviado exitosamente, revisa tu Email');
                    
                }
                else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('/auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }


    //Para recuperar la contraseña
    public static function recuperar(Router $router) {
        
        $alertas = [];
        $error = false;

        $token = $_GET['token'];
        
        //Buscamos a el usuario por medio de su token
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer la nueva contraseña y guardarla
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null; //Para que borre la coontraseña anterior
                $usuario->password = $password->password;  //Asignamos la nueva contraseña al campo password del usuario(de la BD)
                $usuario->hashPassword();
                $usuario->token = null; //Para que borre la coontraseña anterior

                $resultado = $usuario->guardar(); //Va a actualizar al usuario con la nueva contraseña
                if($resultado) {
                    header('Location: /');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('/auth/recuperar-contraseña', [
            'alertas' => $alertas,
            'error' => $error 
        ]);
    }


    //Para crear una cuenta
    public static function crear(Router $router) {
        
        $usuario = new Usuario;
        //Alertas Vacias
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas este vacio
            if (empty($alertas)) {
                //Verificar que el usuario no exista
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    //Si el usuario ya existe
                    $alertas = Usuario::getAlertas();
                }
                else {
                    //Hasheamos el password
                    $usuario->hashPassword();

                    //Generamos un Token unico
                    $usuario->crearToken();

                    //Enviamos el Email al usuario
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token); //Creamos la instancia con los atributos que requiere el constructor 
                    $email->enviarConfirmacion();

                    //Creamos el usuerio
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    }

                    // debuguear($usuario);
                }
            }
        }

        $router->render('/auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function mensaje(Router $router) {

        $router->render('/auth/mensaje');
    }


    public static function confirmar(Router $router) {

        //Alertas Vacias
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            //Mostramos el mensaje de error
            Usuario::setAlerta('error', 'Token no Válido');
        }
        else{
            //Modificar a usuario confirmado
            $usuario->confirmado = '1';
            $usuario->token = null; //Para borrar el token
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente'); //Mostramos el mensaje de exito   
        }

        //Obtenemos las alertas
        $alertas = Usuario::getAlertas(); //Para que las alertas que se estan guardando en memoria(setAlerta), se puedan leer antes de renderizar la vista

        //Renderizar la vista
        $router->render('/auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
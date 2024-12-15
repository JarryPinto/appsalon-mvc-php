<?php

namespace Model;

class Usuario extends ActiveRecord{

    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }


    //Validacion Para poder crear una cuenta
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Debes Poner tu Nombre';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'Debes Poner tu Apellido';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'Tu telefono es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Debes Poner un Email';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Debes Poner una Contraseña';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener por lo menos 6 caracteres';
        }

        return self::$alertas;
    }
    //Validacion Para poder Iniciar Sesión
    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = 'Debes Poner tu Email';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Debes Poner tu Contraseña';
        }

        return self::$alertas;
    }
    //Validar el email para recuperar password
    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'][] = 'Debes Poner tu Email';
        }

        return self::$alertas;
    }
    //Validar el password para restablecerla
    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'][] = 'Debes Poner la Nueva Contraseña';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener por lo menos 6 caracteres';
        }

        return self::$alertas;
    }
    

    //Revisamos si el usuario ya existe
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'Este usuario ya esta registrado';
        }

        return $resultado;
    }


    //Hashear las password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    //Creamos un token unico
    public function crearToken() {
        $this->token = uniqid(); //Para generar un id unico 
    }


    //Comprobamos y si el usuario ya esta verificado
    public function comprobarPasswordAndVerificado($password) {

        $resultado = password_verify($password, $this->password);
        
        if (!$resultado || !$this->confirmado) {
           self::$alertas['error'][] = 'Contraseña Incorrecta o aún no has confirmado tu cuenta';
        }
        else {
           return true;
        }
    }

}
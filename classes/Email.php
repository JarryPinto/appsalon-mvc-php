<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    
    public function enviarConfirmacion() {

        //Creamos el objeto del email
        $email = new PHPMailer();
        $email->isSMTP(); //Protocolo de envio de emails
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];
        //$email->SMTPSecure = 'tls';


        //Configuramos el contenido del mail
        $email->setFrom('cuentas@appsalon.com'); //(Quien envia el email)
        $email->addAddress('cuentas@appsalon.com', 'AppSalon.com'); //(A que email va a llegar ese correo)
        $email->Subject = 'Confirma tu cuenta'; //El mensaje que va a llegar una ves que tengamos un nuevo email (Lo primero que ek usuario va a leer)

        //Set HTML
        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = "<html>"; 
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Trasquilosos, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, solo ignora este mensaje</p>";
        $contenido .= "</html>"; 
        
        $email->Body = $contenido;

        //Enviar el email
        $email->send();
    }

    //Para enviar un email para restablecer una contraseña
    public function enviarInstrucciones() {

        //Creamos el objeto del email
        $email = new PHPMailer();
        $email->isSMTP(); //Protocolo de envio de emails
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];
        //$email->SMTPSecure = 'tls';


        //Configuramos el contenido del mail
        $email->setFrom('cuentas@appsalon.com'); //(Quien envia el email)
        $email->addAddress('cuentas@appsalon.com', 'AppSalon.com'); //(A que email va a llegar ese correo)
        $email->Subject = 'Reestablece tu contraseña'; //El mensaje que va a llegar una ves que tengamos un nuevo email (Lo primero que ek usuario va a leer)

        //Set HTML
        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $contenido = "<html>"; 
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu contraseña, presiona el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a> </p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, solo ignora este mensaje.</p>";
        $contenido .= "</html>"; 
        
        $email->Body = $contenido;

        //Enviar el email
        $email->send();
    }
}
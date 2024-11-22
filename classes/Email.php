<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UFT-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>". $this->nombre .  "</strong> Confirma tu cuenta creada en Barberia, presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=". $this->token . "'>Confirmar cuenta</a> </p>";
        $contenido .= "<p>Si no fuiste tu, ignora este mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();

    }
}
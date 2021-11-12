<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;// Al que mandamos el email
    protected $nombre; // Nombre del que envia el email
    protected $token; // Token para validar el email

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        // Configuracion de Mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '0aa2429c90a0f5';
        $mail->Password = '3f8880e6995f75';

        // Configuracion de PHPMailer
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'UpTask.com');
        $mail->Subject = 'Confirmacion de registro';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong> Has Creado tu Cuenta en UpTask, solo confirmala apretando el siguiente link</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar?token=" .$this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Sí tu no has creado la cuenta ignora el mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
        
    }

    public function enviarInstrucciones() {
        // Configuracion de Mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '0aa2429c90a0f5';
        $mail->Password = '3f8880e6995f75';

        // Configuracion de PHPMailer
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'UpTask.com');
        $mail->Subject = 'Reestablece tu password';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong> Parece que has olvidado tu contraseña, presiona el siguiente link para introducir tu nueva contraseña.</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/reestablecer?token=" .$this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Sí tu no has creado la cuenta ignora el mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
        
    }

    
}
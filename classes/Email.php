<?php 

namespace Classes;

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
        
    }
}


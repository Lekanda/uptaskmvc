<?php 

namespace Model;


class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];



    public function __construct($args=[]) {
        $this->id =$args['id'] ?? null;
        $this->nombre =$args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->password_nuevo2 = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }



    public function validarLogin() : array{
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no valido';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function validarNuevaCuenta() : array{
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'Password minimo 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'Los passwords no coinciden';
        }

        return self::$alertas;
    }

    public function validarEmail() : array{
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no valido';
        }
        return self::$alertas;
    }

    public function validarPassword() : array{
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'Password minimo 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'El password no coincide';
        }

        return self::$alertas;
    }


    public function validarNuevoPassword() : array{
        if(!$this->password_actual){
            self::$alertas['error'][] = 'El password actual es obligatorio';
        }
        if(!$this->password_nuevo){
            self::$alertas['error'][] = 'El password nuevo es obligatorio';
        }
        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = 'Password nuevo minimo 6 caracteres';
        }
        if($this->password_nuevo !== $this->password_nuevo2){
            self::$alertas['error'][] = 'El password no coincide';
        }

        return self::$alertas;
    }


    public function validarPerfil() : array{
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        return self::$alertas;
    }


    // Comprobar el Password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password);
    }


    // Hashear Password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar Token
    public function crearToken() : void{
        $this->token = md5(uniqid(rand(), true));
    }



}
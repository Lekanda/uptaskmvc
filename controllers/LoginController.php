<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            unset($usuario->password2);
            $alertas = $usuario->validarLogin();
            if(empty($alertas)){
                // Buscar usuario por email
                $usuario = Usuario::where('email',$usuario->email);
                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error','Usuario no existe o cuenta no confirmada');
                } else {
                    // Comprobar password
                    if(password_verify($_POST['password'],$usuario->password)){
                        // Guardar usuario en Session
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        // Redireccionar a home
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error','Password incorrecto');
                        
                    }
                }
            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);
    }


    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    
    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email',$usuario->email);
                if($existeUsuario){
                    Usuario::setAlerta('error','Ese email ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();
                    // Eliminar password2
                    unset($usuario->password2);
                    // Generar Token
                    $usuario->crearToken();
                    // Guardar en la base de datos
                    $resultado = $usuario->guardar();
                    // Mandar el mail
                    $email= new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    // debuguear($email);
                    // redireccionar a Iniciar sesion
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Comprobar que existe el email
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email',$usuario->email);
                if ($usuario && $usuario->confirmado) {
                    // Generar token
                    $usuario->crearToken();

                    unset($usuario->password2);
                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar el email
                    $email= new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // Imprimir la alerta
                    Usuario::setAlerta('exito','Se ha enviado un email a tu cuenta con las instrucciones');
                } else {
                    Usuario::setAlerta('error','Ese email no esta registrado o no esta confirmada la cuenta');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        // debuguear($alertas);
        $router->render('auth/olvide',[
            'titulo' => 'Recuperar Cuenta',
            'alertas' => $alertas
        ]);
    }



    public static function reestablecer(Router $router){

        $token = s($_GET['token']);
        $mostrar = true;
        if(!$token){
            header('Location: /');
        }
        // Identificar el usuario con este token
        $usuario = Usuario::where('token',$token);
        if(empty($usuario)){
            Usuario::setAlerta('error','El token no es valido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // A??adir un nuevo password
            $usuario->sincronizar($_POST);
            // Validar  el password
            $alertas = $usuario->validarPassword();
            if(empty($alertas)){
                // Hashear el password
                $usuario->hashPassword();
                // Eliminar password2
                unset($usuario->password2);
                // Borrar el token
                $usuario->token = null;
                // Guardar el usuario
                $resultado=$usuario->guardar();
                if($resultado){
                    // Redireccionar a Iniciar sesion
                    header('Location: /');
                }
                
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer',[
            'titulo' => 'Restablecer Cuenta',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }



    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo' => 'Mensaje Restablecer Cuenta'
        ]);
    }



    public static function confirmar(Router $router){
        $token = s($_GET['token']);
        if (!$token) {
            header('Location: /');
        }
        // Encontrar al usuario
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            // Token mal o no se encontro
            Usuario::setAlerta('error', 'El token no es valido');
        } else {
            // confirmar la cuenta
            $usuario->confirmado = 1;
            unset($usuario->password2);
            $usuario->token = null;
            $resultado=$usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada');
            // if ($resultado) {
            //     header('Location: /');
            // } else {
            //     Usuario::setAlerta('error', 'No se pudo confirmar la cuenta');
            // }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar',[
            'titulo' => 'Cuenta reestablecida',
            'alertas' => $alertas
        ]);
    }

    
}


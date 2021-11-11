<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {



        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesion'
        ]);
    }


    public static function logout() {
        echo 'Desde logout';

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
                    // debuguear($usuario);
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
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }

        $router->render('auth/olvide',[
            'titulo' => 'Recuperar Cuenta'
        ]);
    }



    public static function reestablecer(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $passwords = $_POST;
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            debuguear($passwords);
        }

        $router->render('auth/reestablecer',[
            'titulo' => 'Restablecer Cuenta'
        ]);
    }



    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo' => 'Mensaje Restablecer Cuenta'
        ]);
    }



    public static function confirmar(Router $router){
        $router->render('auth/confirmar',[
            'titulo' => 'Cuenta reestablecida'
        ]);
    }

    
}


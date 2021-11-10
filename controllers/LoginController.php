<?php 

namespace Controllers;

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



        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }

        $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta UpTask'
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



    public static function confirmar(){
        echo 'Desde confirmar';
    }


    
}


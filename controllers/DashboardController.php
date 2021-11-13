<?php 

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController {





    public static function index(Router $router) {
        session_start();
        isAuth();

        $router->render('dashboard/index',[
            'titulo' => 'Proyectos'
        ]);
    }






    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);
            // Validaciones
            $alertas = $proyecto->validarProyecto();
            if(empty($alertas)){
                // Generar token para campo de url
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                // campo de PropietarioId
                $proyecto->propietarioId = $_SESSION['id'];
                $resultado = $proyecto->guardar();
                // debuguear($resultado);
                // Redireccionar a la url generada
                header('Location: /proyecto?url=' . $proyecto->url);
            }

        }

        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }








    public static function perfil(Router $router){
        session_start();

        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil'
        ]);
    }

}
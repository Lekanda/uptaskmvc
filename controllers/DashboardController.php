<?php 

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController {


    public static function index(Router $router) {
        session_start();
        isAuth();

        $proyectos = Proyecto::belongsTo('propietarioId', $_SESSION['id']);
        // debuguear($proyectos);

        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
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
                // Redireccionar a la url generada
                header('Location: /proyecto?url=' . $proyecto->url);
            }

        }

        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }



    public static function proyecto(Router $router){
        session_start();
        isAuth();

        // Revisar que la persona que esta visitando el proyecto sea el propietario
        $url = $_GET['url'];
        if(!$url){
            header('Location: /dashboard');
        }
        $proyecto = Proyecto::where('url', $url);
        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');
        }
        // debuguear($proyecto);

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);

    }



    public static function perfil(Router $router){
        session_start();

        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil'
        ]);
    }

}
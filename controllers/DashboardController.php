<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;

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
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPerfil();
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $_SESSION['id']){
                    // Mensaje de error. Ya existe el usuario
                    Usuario::setAlerta('error','Ese email ya esta registrado');
                }else{
                    // Guardar el Usuario
                    $usuario->guardar();
                    // Alerta todo ok
                    Usuario::setAlerta('exito', 'Perfil actualizado correctamente');
                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }




    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Sincronizar los datos del formulario con el objeto Usuario
            $usuario->sincronizar($_POST);
            // Validar los datos del formulario
            $alertas = $usuario->validarNuevoPassword();
            if (empty($alertas)) {
                $resultado = $usuario->comprobar_password();
                if($resultado){
                    // Asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;
                    // Hashear el password nuevo
                    $usuario->hashPassword();
                    // Eliminar propiedades del bejeto que no se guardan
                    unset($usuario->password2);
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    unset($usuario->password_nuevo2);
                    // Guardar en la base de datos
                    $resultado = $usuario->guardar();
                    if($resultado){
                        // Mensaje de exito
                        Usuario::setAlerta('exito', 'Password actualizado correctamente');
                    }
                    
                   
                }else{
                    // Mensaje de error. El password actual no coincide
                    Usuario::setAlerta('error', 'El password actual no coincide');
                    // $alertas = Usuario::getAlertas();
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('dashboard/cambiar-password',[
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
}
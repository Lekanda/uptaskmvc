<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController {

    public static function index() {
        echo "TareaController::index()";
    }


    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            // Sí no existe el proyecto o el usuario no es el que la creo...
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la Tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 

            // Todo bien; instanciar y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente'
            ];
            echo json_encode($respuesta);
        }
    }



    public static function actualizar() {
        echo "TareaController::actualizar()";
    }
    public static function eliminar() {
        echo "TareaController::eliminar()";
    }
}
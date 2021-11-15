<?php 

namespace Controllers;

use Model\Proyecto;

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
            } else {
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea Agregada correctamente'
                ];
                echo json_encode($respuesta);
                return;
            }

        }
    }



    public static function actualizar() {
        echo "TareaController::actualizar()";
    }
    public static function eliminar() {
        echo "TareaController::eliminar()";
    }
}
<?php 

namespace Controllers;

class TareaController {

    public static function index() {
        echo "TareaController::index()";
    }
    public static function crear() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo json_encode($_POST);
        }
    }
    public static function actualizar() {
        echo "TareaController::actualizar()";
    }
    public static function eliminar() {
        echo "TareaController::eliminar()";
    }
}
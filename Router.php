<?php

namespace MVC;

class Router{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }


    public function comprobarRutas() {
        $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
    
        // Separar la URL del Query String (parámetros GET)
        $urlActual = explode('?', $urlActual)[0];
    
        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
    
        if($fn) {
            // Llamar al controlador asociado a la ruta
            call_user_func($fn, $this);
        } else {
            // Mostrar error 404 si la ruta no existe
            http_response_code(404);
            echo "Página no encontrada";
        }
    }

    // Mostrar Vistas
    public function render($view, $datos = []) {
        
        foreach($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }

    public function renderAdmin($view, $datos = []) {
        
        foreach($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include __DIR__ . "/views/$view.php";

        $contenidoAdmin = ob_get_clean();
        include __DIR__ . "/views/admin/layoutAdmin.php";
    }
}
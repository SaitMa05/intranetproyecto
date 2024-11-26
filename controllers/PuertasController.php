<?php

namespace Controllers;
use Controller;
use MVC\Router;
use Model\PuertasManejoModel;


class PuertasController{

    
    public static function index(Router $router){

        iniciarSession();
        adminSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];

        $titulo = "Listado de Puertas";

        $puertas = new PuertasManejoModel();
        $puertasListado = $puertas->obtener();        

        

        // Arreglo para asociar los movimientos a las puertas
        $puertasConMovimientos = [];

        // Asociar los movimientos con las puertas
        foreach ($puertasListado as $puerta) {
            $puertaConMovimientos = (array) $puerta; // Convertimos el objeto a array para manipularlo
            
            $puertaConMovimientos = [
                'id' => $puerta->id,
                'nombre' => $puerta->nombre,
                'descripcion' => $puerta->descripcion,
            ];

            $puertasConMovimientos[] = $puertaConMovimientos;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($puertasConMovimientos); // Devolver la lista de puertas con sus movimientos
            exit;
        }
        
        $router->renderAdmin('admin/puertas/index', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
            'puertasListado' => $puertasConMovimientos
        ]);
    }

    public static function crear(){
        session_start();
        $arrayDatos = $_POST;
        $usuario = $_SESSION['nombreUsuario'];
        
        $puertasModel = new PuertasManejoModel($arrayDatos);
        $puertasModel->persistir($usuario);

        echo json_encode([
            'success' => true,
            'message' => 'Puerta Creada Correctamente'
        ]);
        
        exit;
    }

    public static function movimientos(Router $router){
        iniciarSession();
        adminSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Movimientos de Puertas";


        $movimientosModel = new PuertasManejoModel();
        $movimientos = $movimientosModel->movimientosObtener(); 
        $movimientosArray = [];

        // Asociar los movimientos con las puertas
        foreach ($movimientos as $movimiento) {
            $movimientoData = [ // Cambiar el nombre de la variable para claridad
                'nombreUsuario' => $movimiento->nombreUsuario,
                'apellidoUsuario' => $movimiento->apellidoUsuario,
                'nombrePuerta' => $movimiento->nombrePuerta,
                'fechaApertura' => $movimiento->fechaApertura,
            ];

            $movimientosArray[] = $movimientoData; // Agregar al array principal
        }

        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($movimientosArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }

        $router->renderAdmin('admin/puertas/movimientos', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
        ]);
    }

    public static function eliminar(){
        iniciarSession();

        $id = $_POST['id'];
        $usuario = $_SESSION['nombreUsuario'];

        $puertasModel = new PuertasManejoModel(['id' => $id]);
        $puertasModel->eliminar($usuario);

        echo json_encode([
            'success' => true,
            'message' => 'Puerta eliminada correctamente'
        ]);
        
        exit;
    }

    public static function editar(){
        session_start();
        $arrayDatos = $_POST;
        $usuario = $_SESSION['nombreUsuario'];
        
        $puertasModel = new PuertasManejoModel($arrayDatos);
        $puertasModel->persistir($usuario);

        echo json_encode([
            'success' => true,
            'puerta' => $arrayDatos,
            'message' => 'Puerta Editada Correctamente'
        ]);
        
        exit;
    }

    
}


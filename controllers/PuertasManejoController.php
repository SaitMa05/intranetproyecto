<?php

namespace Controllers;
use Controller;
use MVC\Router;
use Model\PuertasManejoModel;

class PuertasManejoController{

    public static function index(Router $router) {
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Puertas";

        // Obtener las puertas desde el modelo
        $puertas = new PuertasManejoModel();
        $puertasListado = $puertas->obtener();

        // Obtener los movimientos de todas las puertas
        // $movimientos = $puertas->movimientoObtener();
        

        // Arreglo para asociar los movimientos a las puertas
        $puertasConMovimientos = [];

        // Asociar los movimientos con las puertas
        foreach ($puertasListado as $puerta) {
            $puertaConMovimientos = (array) $puerta; // Convertimos el objeto a array para manipularlo
            // $puertaConMovimientos['movimientos'] = []; // Inicializamos la lista de movimientos

            $puertaConMovimientos = [
                'id' => $puerta->id,
                'nombre' => $puerta->nombre,
                'descripcion' => $puerta->descripcion,
                
            ];

            // foreach ($movimientos as $mov) {
            //     if ($mov->fkPuertas == $puerta->id) { // Comparamos si los movimientos pertenecen a la puerta actual
            //         $puertaConMovimientos['movimientos'][] = [
            //             'fechaApertura' => $mov->fechaApertura,
            //             'nombreUsuario' => $mov->nombreUsuario
            //         ];
            //     }
            // }

            // Añadimos la puerta con sus movimientos al arreglo
            $puertasConMovimientos[] = $puertaConMovimientos;
        }

        // Si es una solicitud AJAX, devolver JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($puertasConMovimientos); // Devolver la lista de puertas con sus movimientos
            exit;
        }

        // Si no es una solicitud AJAX, renderizar la vista HTML
        $router->render('puertas/index', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
            'puertasListado' => $puertasConMovimientos
        ]);
    }


    public static function movimiento(){
        iniciarSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fkPuertas = $_POST['fkPuertas'];
            $fkUsuario = $_SESSION['id'];
            

            $movimiento = new PuertasManejoModel([
                'fkPuertas' => $fkPuertas,
                'fkUsuario' => $fkUsuario
            ]);


            // header('X-CSRF-Token: ' . $token);

            $movimiento->persistirMovimiento();
            
            if ($fkPuertas && $fkUsuario) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Puerta abierta correctamente'
                ]);
                exit;
            } else {
                echo json_encode([
                    'estado' => 'error',
                    'mensaje' => 'Error al registrar el movimiento'
                ]);
                exit;
            }
        }
    }

    // public static function token() {
    //     $tokenModel = new PuertasManejoModel([
    //         'fkPuertas' => $_POST['fkPuertas']
    //     ]);
    
    //     $tokenPuerta = $tokenModel->obtenerTokenPuertas();
    //     $token = $tokenPuerta[0]->token;
    
    //     // Envía el token en el encabezado de respuesta
    //     header('X-CSRF-Token: ' . $token);
        
    //     // Envía una respuesta en JSON para confirmar el envío al cliente
    //     echo json_encode([
    //         'status' => 'success',
    //         'message' => 'Token enviado en el encabezado X-CSRF-Token'
    //     ]);
    //     var_dump($_SERVER);
    //     exit;
    
    // }

}
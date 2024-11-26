<?php

namespace Controllers;
use Controller;
use MVC\Router;
use Model\ExpoModel;


class ExpoController
{
    public static function index(Router $router)
    {

        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Expo Asistencias";





        $router->render('expo/index', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }

    public static function enviar(Router $router)
    {
        iniciarSession();
        $datosArray = $_POST;

        $expo = new ExpoModel($datosArray);
        $usuarioId = $_SESSION['id'];

        $resultado = $expo->expoAsistencias_persistir($usuarioId);
        $ultimoId = $resultado[0]->id;
        $resultadosAcompanantes = []; // Array para guardar los resultados de cada inserción

        if (!empty($_POST['acompañantes'])) {
            foreach ($_POST['acompañantes'] as $nombre_acompañante) {
                $nombreCompania = $nombre_acompañante['nombre'];

                $acompañante = new ExpoModel([
                    'idCompania' => $ultimoId,
                    'nombreCompania' => $nombreCompania,
                ]);

                $resultado = $acompañante->expoCompania_persistir();
                $resultadosAcompanantes[] = $resultado; // Agrega cada resultado al array
            }
        }

        if ($resultado) {
            echo json_encode([
                'success' => true,
                'message' => 'Datos enviados correctamente'
            ]);
            exit;
        }
    }

    public static function estadisticas(Router $router)
    {
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Estadisticas de la Expo";

        $expoModel = new ExpoModel();
        $tiposPersonas = $expoModel->tiposPersonas();
        $horarioPico = $expoModel->horarioPico();
        $personasSolas = $expoModel->personasSolas();
        $personasEdad = $expoModel->obtenerEdad();
        $edades = $expoModel->obtenerTodasEdades();

        $tiposPersonasArray = [];
        $horarioPicoArray = [];
        $personasSolasArray = [];
        $personasEdadArray = [];
        $edadesArray = [];

        foreach($tiposPersonas as $tipoPersona){
            $tiposPersonasData = [
                'tipo' => $tipoPersona->tipo,
                'total' => $tipoPersona->total
            ];

            $tiposPersonasArray[] = $tiposPersonasData;
        }

        foreach($horarioPico as $horario){
            $horarioPicoData = [
                'hora' => $horario->hora,
                'totalPersonas' => $horario->totalPersonas
            ];

            $horarioPicoArray[] = $horarioPicoData;
        }

        foreach($personasEdad as $personaEdad){
            $personaEdadData = [
                'rangoEdad' => $personaEdad->rangoEdad,
                'totalPersonas' => $personaEdad->totalPersonas
            ];

            $personasEdadArray[] = $personaEdadData;
        }

        foreach($personasSolas as $persona){
            $personasSolasData = [
                'personasSolasData' => $persona->personasSolasData,
                'personasConAcompanantes' => $persona->personasConAcompanantes,
            ];

            $personasSolasArray[] = $personasSolasData;
        }

        foreach($edades as $edad){
            $edadData = [
                'edad' => $edad->edad,
                'totalPersonas' => $edad->totalPersonas,
            ];

            $edadesArray[] = $edadData;
        }

        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
        
            // Combinar ambos arrays en un array asociativo
            $response = [
                'tiposPersonas' => $tiposPersonasArray,
                'horarioPico' => $horarioPicoArray,
                'personasSolas' => $personasSolasArray,
                'personasEdad' => $personasEdadArray,
                'edades' => $edadesArray
            ];
        
            // Enviar la respuesta JSON
            echo json_encode($response);
            exit;
        }

        $router->renderAdmin('admin/expo/estadisticas', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }
    
    public static function personas(Router $router)
    {
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Personas de la Expo";

        $expoModel = new ExpoModel();
        $personas = $expoModel->obtenerPersonas();
        $personasArray = [];
        foreach($personas as $persona){
            $personasData = [
                'nombre' => $persona->nombre,
                'apellido' => $persona->apellido,
                'email' => $persona->email,
                'edad' => $persona->edad,
                'fecha' => $persona->fecha,
                'compania' => $persona->compania,
                'nombreUsuario' => $persona->nombreUsuario

            ];

            $personasArray[] = $personasData;
        }
        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($personasArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }

        $router->renderAdmin('admin/expo/personas', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }

    public static function empresas(Router $router)
    {
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Empresas de la Expo";

        $expoModel = new ExpoModel();
        $empresas = $expoModel->obtenerEmpresas();
        $empresasArray = [];
        foreach($empresas as $empresa){
            $empresaData = [
                'empresa' => $empresa->empresa,
                'nombre' => $empresa->nombre,
                'apellido' => $empresa->apellido,
                'email' => $empresa->email,
                'edad' => $empresa->edad,
                'fecha' => $empresa->fecha,
                'cantidad' => $empresa->cantidad,
                'info' => $empresa->info,
                'nombreUsuario' => $empresa->nombreUsuario
            ];

            $empresasArray[] = $empresaData;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($empresasArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }

        $router->renderAdmin('admin/expo/empresas', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }

    public static function escuelas(Router $router)
    {
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Escuelas de la Expo";

        $expoModel = new ExpoModel();
        $escuelas = $expoModel->obtenerEscuelas();
        $escuelasArray = [];

        foreach($escuelas as $escuela){
            $escuelaData = [
                'escuela' => $escuela->escuela,
                'nombre' => $escuela->nombre,
                'apellido' => $escuela->apellido,
                'email' => $escuela->email,
                'edad' => $escuela->edad,
                'fecha' => $escuela->fecha,
                'cantidad' => $escuela->cantidad,
                'info' => $escuela->info,
                'nombreUsuario' => $escuela->nombreUsuario
            ];

            $escuelasArray[] = $escuelaData;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($escuelasArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }

        $router->renderAdmin('admin/expo/escuelas', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }
}
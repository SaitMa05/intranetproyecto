<?php

namespace Controllers;
use Controller;
use MVC\Router;
use Model\AsistenciasModel;
use Model\CursosModel;
use Model\AlumnosModel;

class AsistenciasController{


    public static function index(Router $router){
        iniciarSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $rol = $_SESSION['rol'];
        $titulo = "Asistencias";


        $cursos = new CursosModel();
        $cursos = $cursos->obtenerCursos();

        
            
        $router->render('asistencias/index', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
            'rol' => $rol,
            'cursos' => $cursos
        ]);

    }

    public static function alumnosPorCurso(Router $router)
    {
        if (isset($_POST['cursos'])) {
            $curso_id = $_POST['cursos'];

            // Obtener todos los alumnos del curso usando el modelo
            $alumnosModel = new AlumnosModel();
            $alumnos = $alumnosModel->obtenerAlumnosPorCurso($curso_id);

            // Excluir las columnas 'telefono' y 'dni'
            $columnasExcluidas = ['telefono', 'dni'];
            $alumnosFiltrados = array_map(function($alumno) use ($columnasExcluidas) {
                // Convertir objeto a array
                $alumnoArray = get_object_vars($alumno);
                return array_diff_key($alumnoArray, array_flip($columnasExcluidas));
            }, $alumnos);

            // Devolver los alumnos filtrados como JSON
            header('Content-Type: application/json');
            echo json_encode($alumnosFiltrados);
            exit;
        } else {
            echo json_encode([]);
            exit;
        }
    }
    

    public static function enviar(Router $router) {
        iniciarSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $asistencias = $_POST['asistencia'] ?? [];
            $tardanzas = $_POST['tardanza'] ?? [];
            $detalles = $_POST['detalles'] ?? null;
            $mediafalta = $_POST['media'] ?? [];
            $cuartofalta = $_POST['cuarto'] ?? [];
            $fkUsuario = $_SESSION['id'];


            $resultados = [];

            // Procesa cada alumno en el array de asistencias
            foreach ($asistencias as $fkAlumno => $asistencia) {
                $tardanza = $tardanzas[$fkAlumno] ?? 0;
                $media = $mediafalta[$fkAlumno] ?? 0;
                $cuarto = $cuartofalta[$fkAlumno] ?? 0;
                $fkAlumnos = $fkAlumno;
                // Almacena el resultado en el arreglo
                $resultados[] = [
                    'asistencia' => $asistencia,
                    'fkUsuario' => $fkUsuario,
                    'fkAlumnos' => $fkAlumnos,
                    'tardanza' => $tardanza,
                    'detalles' => $detalles ?? "No hay nada que agregar",
                    'media' => $media,
                    'cuarto' => $cuarto
                    
                ];
            }
            

            foreach ($resultados as $registro) {
                
                $asistenciasModel = new AsistenciasModel($registro);
                $asistenciasModel->persistir();
            }
            

            echo json_encode([
                'status' => true,
                'data' => $resultados,
                'message' => 'Asistencias registradas correctamente'
            ]);
            
            exit;
            
        } else {
            echo "Error: Método de solicitud no permitido.";
            exit;
        }
    }
    
    

}

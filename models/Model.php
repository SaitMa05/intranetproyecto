<?php
namespace Model;
require_once ( __DIR__ . "/../core/LibFormat.php");

class Model {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    // Definir la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }
    
    public static function consultarSQL($query) {
        // Ejecutar la consulta
        if (self::$db->real_query($query)) {
            // Almacenar el resultado completo de la consulta
            $resultado = self::$db->store_result();
    
            // Si no hay resultados, retornar un array vacío
            if (!$resultado) {
                return [];
            }
    
            // Iterar sobre los resultados
            $array = [];
            while ($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }
    
            // Liberar los resultados
            $resultado->free();
    
            // Asegurarse de que no quedan más resultados pendientes
            while (self::$db->more_results()) {
                self::$db->next_result();
            }
    
            // Retornar los resultados obtenidos
            return $array;
        } else {
            // Manejo de errores
            throw new Exception('Error en la consulta: ' . self::$db->error);
        }
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function generarToken($longitud = 32) {
        $bytesAleatorios = random_bytes($longitud / 2);
        return bin2hex($bytesAleatorios);
    }

    
    
}
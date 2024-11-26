<?php

namespace Model;


class ExpoModel extends Model{
    protected static $tabla = 'expoAsistentes';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'fecha'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $edad;
    public $fecha;
    public $escuela;
    public $empresa;
    public $cantidad;
    public $info;
    public $fkUsuario;

    public $idCompania;
    public $nombreCompania;

    public $tipo;
    public $total;

    public $hora;
    public $totalPersonas;

    public $personasSolasData;
    public $personasConAcompanantes;
    public $compania;
    public $nombreUsuario;
    public $rangoEdad;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->edad = $args['edad'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->escuela = $args['escuela'] ?? null;
        $this->empresa = $args['empresa'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->info = $args['info'] ?? null;
        $this->fkUsuario = $args['fkUsuario'] ?? null;

        $this->idCompania = $args['idCompania'] ?? null;
        $this->nombreCompania = $args['nombreCompania'] ?? null;
    }

    public function expoAsistencias_persistir($fkUsuario){
        $sql = "CALL expoAsistentes_persistir(";
        $sql .= LibFormat::intEmptyToNull($this->id) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->nombre) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->apellido) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->email) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->edad) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->escuela) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->empresa) . ", ";
        $sql .= LibFormat::intEmptyToNull($this->cantidad) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->info) . ", ";
        $sql .= LibFormat::intEmptyToNull($fkUsuario) . ")";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function expoCompania_persistir(){
        $sql = "CALL expoCompania_persistir(";
        $sql .= LibFormat::intEmptyToNull($this->id) . ", ";
        $sql .= LibFormat::intEmptyToNull($this->idCompania) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->nombreCompania) . ")";
        // var_dump($sql);
        // exit;
        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function tiposPersonas(){
        $sql = "CALL expo_obtenerTiposPersonas()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function horarioPico(){
        $sql = "CALL expo_registroPorHora()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function personasSolas(){
        $sql = "CALL expo_personasSolas()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function obtenerPersonas(){
        $sql = "CALL expo_obtenerPersonas()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function obtenerEmpresas(){
        $sql = "CALL expo_obtenerEmpresas()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function obtenerEscuelas(){
        $sql = "CALL expo_obtenerEscuelas()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function obtenerEdad(){
        $sql = "CALL expo_obtenerEdad()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function obtenerTodasEdades(){
        $sql = "CALL expo_obtenerTodasEdades()";

        $resultado = self::consultarSQL($sql);
        return $resultado;
    }


    
}
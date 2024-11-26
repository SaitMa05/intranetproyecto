<?php

namespace Model;

class PuertasManejoModel extends Model{
    protected static $tabla = 'puertas';
    protected static $columnasDB = [
        'id',
        'nombre',
        'descripcion',
        'fechaCreacion',
        'fechaModificacion',
        'fechaEliminacion',
        'creadoPor',
        'modificadoPor',
        'eliminadoPor'
    ];

    public $id;
    public $nombre;
    public $descripcion;

    public $abierta;
    public $fechaCreacion;
    public $fechaModificacion;
    public $fechaEliminacion;
    public $creadoPor;
    public $modificadoPor;

    public $eliminadoPor;

    public $fkPuertas;
    public $fkUsuario;
    // public $token;
    
    
    
    public $nombreUsuario;
    public $apellidoUsuario;
    public $nombrePuerta;
    
    public $fechaApertura;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->abierta = $args['abierta'] ?? 0;
        $this->fechaCreacion = $args['fechaCreacion'] ?? null;
        $this->fechaModificacion = $args['fechaModificacion'] ?? null;
        $this->fechaEliminacion = $args['fechaEliminacion'] ?? null;
        $this->creadoPor = $args['creadoPor'] ?? '';
        $this->modificadoPor = $args['modificadoPor'] ?? '';
        $this->eliminadoPor = $args['eliminadoPor'] ?? '';
        // $this->token = $args['token'] ?? '';

        $this->nombrePuerta = $args['nombrePuerta'] ?? '';
        $this->nombreUsuario = $args['nombreUsuario'] ?? '';
        $this->apellidoUsuario = $args['apellidoUsuario'] ?? '';
        $this->fkPuertas = $args['fkPuertas'] ?? '';
        $this->fechaApertura = $args['fechaApertura'] ?? '';

        $this->fkUsuario = $args['fkUsuario'] ?? '';

        
    }

    public function obtener()
    {
        $query = "call puertas_obtener()";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function movimientosObtener(){
        $query = "call movimiento_obtener()";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function eliminar($usuario){
        $sql = "CALL puertas_eliminar(";
        $sql .= LibFormat::intEmptyToNull($this->id) . ", ";
        $sql .= LibFormat::strEmptyToNull($usuario) . ")";
        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function persistirMovimiento(){
        $sql = "CALL movimiento_persistir(";
        $sql .= LibFormat::intEmptyToNull($this->fkUsuario) . ", ";
        $sql .= LibFormat::intEmptyToNull($this->fkPuertas) . ")";
        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    public function persistir($usuario){
        $sql = "CALL puertas_persistir(";
        $sql .= LibFormat::intEmptyToNull($this->id) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->nombre) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->descripcion) . ", ";
        $sql .= LibFormat::strEmptyToNull($usuario) . ", ";
        $sql .= LibFormat::strEmptyToNull($usuario) . ")";
        $resultado = self::consultarSQL($sql);
        return $resultado;
    }

    // public function obtenerTokenPuertas(){
    //     $sql = "call obtener_tokenPuertas(";
    //     $sql .= LibFormat::intEmptyToNull($this->fkPuertas) . ")";
    //     $resultado = self::consultarSQL($sql);
    //     return $resultado;
    // }

}
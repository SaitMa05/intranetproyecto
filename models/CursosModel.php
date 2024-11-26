<?php


namespace Model;

class CursosModel extends Model
{

    protected static $tabla = 'asistencias';
    protected static $columnasDB = [
        'id',
        'year',
        'division',
        'fechaCreacion',
        'fechaModificacion',
        'fechaEliminacion',
        'creadoPor',
        'modificadoPor',
        'eliminadoPor',
    ];

    public $id;
    public $year;
    public $division;
    public $fechaCreacion;
    public $fechaModificacion;
    public $fechaEliminacion;
    public $creadoPor;
    public $modificadoPor;

    public $eliminadoPor;




    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->year = $args['year'] ?? null;
        $this->division = $args['division'] ?? 0;
        $this->fechaCreacion = $args['fechaCreacion'] ?? null;
        $this->fechaModificacion = $args['fechaModificacion'] ?? null;
        $this->fechaEliminacion = $args['fechaEliminacion'] ?? null;
        $this->creadoPor = $args['creadoPor'] ?? null;
        $this->modificadoPor = $args['modificadoPor'] ?? null;
        $this->eliminadoPor = $args['eliminadoPor'] ?? null;
    }

    public function obtenerCursos(){
        $sql = "CALL obtener_cursos()";
        $resultado = self::consultarSQL($sql);
        return $resultado;

    }



}
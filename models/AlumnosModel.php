<?php


namespace Model;

class AlumnosModel extends Model
{

    protected static $tabla = 'alumnos';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'fechaCreacion',
        'fechaModificacion',
        'fechaEliminacion',
        'creadoPor',
        'modificadoPor',
        'eliminadoPor',
        'fkCurso'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $dni;
    public $telefono;
    public $fechaCreacion;
    public $fechaModificacion;
    public $fechaEliminacion;
    public $creadoPor;
    public $modificadoPor;
    public $eliminadoPor;
    public $fkCurso;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->fechaCreacion = $args['fechaCreacion'] ?? null;
        $this->fechaModificacion = $args['fechaModificacion'] ?? null;
        $this->fechaEliminacion = $args['fechaEliminacion'] ?? null;
        $this->creadoPor = $args['creadoPor'] ?? null;
        $this->modificadoPor = $args['modificadoPor'] ?? null;
        $this->eliminadoPor = $args['eliminadoPor'] ?? null;
        $this->fkCurso = $args['fkCurso'] ?? null;
    }

    public function obtenerAlumnosPorCurso($idCurso){
        $sql = "CALL obtener_alumnosPorCurso(". LibFormat::intEmptyToNull($idCurso) .")";
        $resultado = self::consultarSQL($sql);
        return $resultado;
    }
}
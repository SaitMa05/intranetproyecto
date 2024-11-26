<?php


namespace Model;

class AsistenciasModel extends Model
{

    protected static $tabla = 'asistencias';
    protected static $columnasDB = [
        'id',
        'fecha',
        'asistencia',
        'fkUsuario',
        'fkAlumnos',
        'fechaCreacion',
        'fechaCreacionProfesor',
        'fechaEliminacion',
        'detalles',
        'tardanza',
        'media',
        'cuarto'
    ];

    public $id;
    public $fecha;
    public $asistencia;
    public $fkUsuario;
    public $fkAlumnos;
    public $fechaCreacion;
    
    public $detalles;
    public $tardanza;
    public $media;
    public $cuarto;
    public $fechaEliminacion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->asistencia = $args['asistencia'] ?? 0;
        $this->fkUsuario = $args['fkUsuario'] ?? null;
        $this->fkAlumnos = $args['fkAlumnos'] ?? null;
        $this->fechaCreacion = $args['fechaCreacion'] ?? date('Y-m-d H:i:s');
        $this->fechaEliminacion = $args['fechaEliminacion'] ?? null;
        $this->detalles = $args['detalles'] ?? null;
        $this->tardanza = $args['tardanza'] ?? 0;
        $this->media = $args['media'] ?? 0;
        $this->cuarto = $args['cuarto'] ?? 0;
    }


    public function persistir()
    {
        $sql = "CALL asistencias_persistir(";
        $sql .= LibFormat::intEmptyToNull($this->asistencia) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->fkUsuario) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->fkAlumnos) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->detalles) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->tardanza) . ", ";
        $sql .= LibFormat::strEmptyToNull($this->media) . ", ";
        $sql .= LibFormat::intEmptyToNull($this->cuarto) . ")";

        $resultado = self::consultarSQL($sql);
        return $resultado;

    }

}
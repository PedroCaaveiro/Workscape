<?php

namespace Model;

class Evento extends ActiveRecord {

    protected static $tabla  = 'eventos';
    protected static $columnasDB = ['id','nombre','descripcion','disponibles','categoria_id','dia_id','hora_id','ponente_id'];

    public $id;
    public $nombre;
    public $descripcion;
    public $disponibles;
    public $categoria_id;
    public $dia_id;
    public $hora_id;
    public $ponente_id;
    public $categoria;
     public $dia;
    public $hora;
    public $ponente;

public function __construct($args = []){

$this->id = $args['id'] ?? null;
$this->nombre = $args['nombre'] ?? '';
$this->descripcion = $args['descripcion'] ?? '';
$this->disponibles = $args['disponibles'] ?? 0;
$this->categoria_id = $args['categoria_id'] ?? 0;
$this->dia_id = $args['dia_id'] ?? 0;
$this->hora_id = $args['hora_id'] ?? 0;
$this->ponente_id = $args['ponente_id'] ?? 0;

}
public function validar() {
    self::$alertas = []; // Asegura que las alertas estén vacías antes de validar

    if (empty(trim($this->nombre))) {
        self::$alertas['error'][] = 'El nombre es obligatorio';
    }

    if (empty(trim($this->descripcion))) {
        self::$alertas['error'][] = 'La descripción es obligatoria';
    }

    if (!filter_var($this->categoria_id, FILTER_VALIDATE_INT) || $this->categoria_id <= 0) {
        self::$alertas['error'][] = 'Elige una categoría válida';
    }

    if (!filter_var($this->dia_id, FILTER_VALIDATE_INT) || $this->dia_id <= 0) {
        self::$alertas['error'][] = 'Elige un día válido';
    }

    if (!filter_var($this->hora_id, FILTER_VALIDATE_INT) || $this->hora_id <= 0) {
        self::$alertas['error'][] = 'Elige una hora válida';
    }

    if (!filter_var($this->disponibles, FILTER_VALIDATE_INT) || $this->disponibles < 0) {
        self::$alertas['error'][] = 'Indica una cantidad válida de lugares disponibles';
    }

    if (!filter_var($this->ponente_id, FILTER_VALIDATE_INT) || $this->ponente_id <= 0) {
        self::$alertas['error'][] = 'Selecciona un ponente válido';
    }

    return self::$alertas;
}

}
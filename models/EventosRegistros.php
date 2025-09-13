<?php
namespace Model;

class EventosRegistros extends ActiveRecord {

    protected static $tabla  = 'eventos_registros';
    protected static $columnasDB = ['id','evento_id','registro_id'];

    public $id;
    public $evento_id;
    public $registro_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->evento_id = isset($args['evento_id']) ? (int) $args['evento_id'] : null;
        $this->registro_id = isset($args['registro_id']) ? (int) $args['registro_id'] : null;
    }
}









?>
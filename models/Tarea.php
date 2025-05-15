<?php

namespace Model;

class Tarea extends ActiveRecord  implements \JsonSerializable{

    protected static $tabla = 'tareas';
    protected static $columnasDB = ['id','nombre','estado','proyectoId'];


    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->proyectoId = $args['proyectoId'] ?? '';
    }
 public function jsonSerialize() : mixed{
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'proyectoId' => $this->proyectoId
        ];
    }
    
}

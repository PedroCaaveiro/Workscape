<?php

namespace Model;

class Usuario extends ActiveRecord{

protected static $tabla = 'usuarios';
protected static $columnasDB = ['id','nombre','email','password','token','confirmado'];



public function __construct($args =[])
{
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? null;
    $this->email = $args['email'] ?? null;
    $this->password = $args['password'] ?? null;
    $this->token = $args['token'] ?? null;
    $this->confirmado = $args['confirmado'] ?? null;
}


}

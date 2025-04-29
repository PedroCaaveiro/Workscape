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
    $this->password2 = $args['password2'] ?? null;
    $this->token = $args['token'] ?? null;
    $this->confirmado = $args['confirmado'] ?? null;
}
// En la clase Usuario
public function getPassword2() {
    return $this->password2;
}




public function validarNuevaCuenta(){

    if (!$this->nombre) {
        self::$alertas['error'][] = 'Porfavor introduzca un Nombre';
    }

    if (!$this->email) {
        self::$alertas['error'][] = 'Porfavor introduzca un E-mail';
    }
    if (!$this->password) {
        self::$alertas['error'][] = 'Porfavor introduzca el Password';
    }
    if (strlen($this->password) < 8) {
        self::$alertas['error'][] = 'Porfavor el password debe tener minimo 8 caracteres';
    }
    if ($this->password !== $this->password2) {
        self::$alertas['error'][] = 'Los passwords no coinciden';
    }
    return self::$alertas;
}

public function hashearPassword(){

        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
}


public function generarToken(){

    $this->token = bin2hex(random_bytes(32)); 

}


}



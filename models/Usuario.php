<?php

namespace Model;

class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];



    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->nuevo_password = $args['nuevo_password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? null;
    }
    // En la clase Usuario
    public function getPassword2()
    {
        return $this->password2;
    }


    public function validarLogin()
    {


        if (!$this->password) {
            self::$alertas['error'][] = 'Porfavor introduzca el Password';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'Porfavor el password debe tener minimo 8 caracteres';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El E-mail es obligatorio';
        }

        return self::$alertas;
    }

    public function validarNuevaCuenta()
    {

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

    public function comprobarPassword(): bool{

        return password_verify($this->password_actual,$this->password);

    }

    public function hashearPassword()
    {

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    public function generarToken()
    {

        $this->token = bin2hex(random_bytes(32));
    }

    public function validarEmail()
    {

        if (!$this->email) {
            self::$alertas['error'][] = 'El E-mail es obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El E-mail no es valido';
        }
        return self::$alertas;
    }


    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'Porfavor introduzca el Password';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'Porfavor el password debe tener minimo 8 caracteres';
        }
        return self::$alertas;
    }
public function validarPerfil() {
    self::$alertas = [];

    if (!trim($this->nombre)) {
        self::$alertas['error'][] = 'El nombre introducido es Obligatorio';
    }

    if (!trim($this->email)) {
        self::$alertas['error'][] = 'El email introducido es Obligatorio';
    }

    return self::$alertas;
}


public  function nuevoPassword(){
if (!$this->password_actual) {
    self::$alertas['error'][] = 'El Password Actual  no puede ir vacio';
}
if (!$this->nuevo_password) {
    self::$alertas['error'][] = 'El Password Actual  no puede ir vacio';
}
if (strlen($this->nuevo_password) < 8) {
    self::$alertas['error'][] = 'El Password debe contener minimo 8 caracteres';
}
return self::$alertas;
}

public function limpiarPasswordActual() {
    $this->password_actual = null;
     $this->nuevo_password = null;
}

}

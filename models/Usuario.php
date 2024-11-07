<?php 

namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'contrasena', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $contrasena;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contrasena = $args['contrasena'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Mensajes de validacion para la creacion
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }    
        if (!$this->contrasena) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }    
        if (strlen($this->contrasena) < 8) {
            self::$alertas['error'][] = 'La contraseña debe tener minimo 8 caracteres';

        }
        if ($_POST['contrasena'] != $_POST['contrasenaC'] ) {
            self::$alertas['error'][] = 'Las contraseñas deben ser iguales';
        }

        return self::$alertas;
    }

    //Revisar si el usuario ya existe
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya existe';
        }
        // } else{
        //     self::$alertas['error'][] = 'El usuario no existe';
        // }

        return $resultado;
    }

    public function hashContraseña(){
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT);

    }

    public function crearToken(){
        $this->token = uniqid(); //para generar un token
    }

    //Mensajes de validacion para el login
    public function validarCuenta(){
  
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }    
        if (!$this->contrasena) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }   

        return self::$alertas;
    }

    public function comprobarContrasenaYVerificado($contrasena){
        $resultado = password_verify($contrasena, $this->contrasena);
     //   debuguear($this->contraseña);
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Contraseña incorrecta o cuenta no confirmada';
        } else{
            return true;
        }
    }

    public function autenticar(){
        session_start();

        //Llenar el arreglo de sesion
        // $_SESSION['usuario'] = $this->email;
        // $_SESSION['login'] = true;

        header('Location: /admin/index');
    }
}
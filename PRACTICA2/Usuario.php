<?php

require_once 'Aplicacion.php';
require_once 'config.php';

class Usuario
{

    public static function login($usuario, $password)
    {
        $user = self::buscaUsuario($usuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }
    
    public static function crea($usuario,$password, $nombre, $apellidos, $direccion, $telefono ,$email, $rol)
    {
        $user = self::buscaUsuario($usuario);
        if($user){
            return false;
        }
        $user = new Usuario($usuario, self::hashPassword($password), $nombre, $apellidos,  $direccion, $telefono ,$email, $rol);
        return $user->guarda($user);
    }

        
    public static function guarda($user)
    {
        if ($user->id !== null) {
            return self::actualiza($user);
        }
        return self::inserta($user);
    }

    private static function inserta($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuario(usuario, password, nombre, apellidos, direccion, telefono, email, rol) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->usuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->direccion)
            ,$conn->real_escape_string($usuario->telefono)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->rol));

        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $usuario->insertaRoles($usuario);
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
   
    private static function insertaRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        //Por defecto el rol es 2, que es el de user
        $rolInsertado = 2;
        //Si el rol es admin lo cambiamos a 1
        if ($usuario->rol === 'admin') {
            $rolInsertado = 1;
            
        }
        //Si el rol es moderador lo cambiamos a 3
        else if($usuario->rol === 'mod'){
            $rolInsertado = 3;
        }     
        $query=sprintf("INSERT INTO rolesusuario(usuario, rol) VALUES (%d, %d)"
            , $conn->real_escape_string($usuario->id)
            , $conn->real_escape_string($rolInsertado));

        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    

    public static function buscaUsuario($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.usuario='%s'", $conn->real_escape_string($usuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['usuario'], $fila['password'], $fila['nombre'], $fila['apellidos'] , $fila['direccion'], $fila['telefono'], $fila['email'], $fila['rol']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['usuario'], $fila['password'], $fila['nombre'], $fila['apellidos'] ,   $fila['direccion'], $fila['telefono'], $fila['email'],$fila['id'], $fila['rol']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
   
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuario U SET usuario = '%s', password='%s', nombre='%s', apellidos='%s',direccion='%s',telefono='%s' ,'email='%s', 'rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->usuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->direccion)
            ,$conn->real_escape_string($usuario->telefono)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id
        );
        if ( $conn->query($query) ) {

            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }

            $result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    
    private static function borra($usuario)
    {
        borraRoles($usuario);
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuario U WHERE U.id = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }

    private $id;

    private $usuario;

    private $password;

    private $nombre;

    private $apellidos;

    private $direccion;

    private $telefono;

    private $rol;

    private $email;

    private function __construct($usuario, $password, $nombre, $apellidos, $direccion, $telefono, $email, $rol, $id = null)
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->rol = $rol;
    }

    public function getId()
    {
        return $this->id;
    }

    public function rol()
    {
        return $this->$rol;
    }

    public function getusuario()
    {
        return $this->usuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    
    public function getTelefono()
    {
        return $this->telefono;
    }


    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}

<?php

require_once 'Aplicacion.php';
require_once 'config.php';

class Usuario
{

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public const MODERADOR_ROLE = 3;

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
        $user = new Usuario($usuario, self::hashPassword($password), $nombre, $apellidos,  $direccion, $telefono ,$email);
        $user->añadeRol($rol);
        return $user->guarda();
    }




    public static function buscaUsuario($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.usuario='%s'", $conn->real_escape_string($usuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['usuario'], $fila['password'], $fila['nombre'], $fila['apellidos'] ,   $fila['direccion'], $fila['telefono'], $fila['email']);
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
                $result = new Usuario($fila['usuario'], $fila['password'], $fila['nombre'], $fila['apellidos'] ,   $fila['direccion'], $fila['telefono'], $fila['email'],$fila['id']);
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

    private static function cargaRoles($usuario)
    {
        $roles=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->id
        );
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuario(usuario, password, nombre, apellidos, direccion, telefono, email) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->usuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->direccion)
            ,$conn->real_escape_string($usuario->telefono)
            , $conn->real_escape_string($usuario->email));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            echo 'aquiiiiii';
            $result = self::insertaRoles($usuario);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        foreach($usuario->roles as $rol) {
            $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"
                , $usuario->id
               // , $rol
               , 2
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuario U SET usuario = '%s', password='%s', nombre='%s', apellidos='%s',direccion='%s',telefono='%s' ,'email='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->usuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->direccion)
            ,$conn->real_escape_string($usuario->telefono)
            , $conn->real_escape_string($usuario->email)
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
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
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

    private $id;

    private $usuario;

    private $password;

    private $nombre;

    private $apellidos;

    private $direccion;

    private $telefono;

    private $roles;

    private $email;

    private function __construct($usuario, $password, $nombre, $apellidos, $direccion, $telefono, $email, $id = null, $roles = [])
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->roles = $roles;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function rol()
    {
        return $this->$roles[0];
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

    public function añadeRol($role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function tieneRol($role)
    {
        if ($this->roles == null) {
            self::cargaRoles($this);
        }
        return array_search($role, $this->roles) !== false;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}

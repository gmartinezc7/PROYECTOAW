<?php

class Conversacion

{

    public static function crea($usuario1, $usuario2, $admin, $idMensaje)
    {
        $conversacion = new Conversacion($idMensaje, $usuario1, $usuario2, $admin);
        return $conversacion->guarda();
    }


    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Conversacion WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Conversacion($fila['idMensaje'], $fila['usuario1'],$fila['usuario2'],$fila['admin'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($conversacion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Conversacion(idMensaje,usuario1,usuario2,admin) VALUES ('%d', '%s', '%s', '%s')"
            , $conn->real_escape_string($conversacion->idMensaje)
            , $conn->real_escape_string($conversacion->usuario1)
            , $conn->real_escape_string($conversacion->usuario2)
            , $conn->real_escape_string($conversacion->admin)
        );
        if ( $conn->query($query) ) {
            $conversacion->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    
    
    private static function actualiza($conversacion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Conversacion C SET idMensaje = '%d', usuario1 ='%s', usuario2 = '%s', admin= '%s' WHERE C.id=%d"
            , $conn->real_escape_string($conversacion->idMensaje)
            , $conn->real_escape_string($conversacion->usuario1)
            , $conn->real_escape_string($conversacion->usuario2)
            , $conn->real_escape_string($conversacion->admin)
            , $conversacion->id
        );
        if ($conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borra($conversacion)
    {
        return self::borraPorId($conversacion->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        }
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Conversacion C WHERE C.id = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;
    private $usuario1;
    private $usuario2;
    private $admin;
    private $idMensaje;

    private function __construct($idMensaje, $usuario1, $usuario2, $admin ,$id = null)
    {
        $this->id = $id;
        $this->usuario1 = $usuario1;
        $this->usuario2 = $usuario2;
        $this->idMensaje = $idMensaje;
        $this->admin = $admin;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getIdMensaje()
    {
        return $this->idMensaje;
    }

    public function getUsuario1()
    {
        return $this->usuario1;
    }

    public function getUsuario2()
    {
        return $this->usuario2;
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
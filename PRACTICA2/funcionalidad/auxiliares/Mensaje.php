<?php

class Mensaje 

{

    public static function crea($fecha, $contenido)
    {
        $mensaje = new Mensaje($fecha, $contenido);
        return $mensaje->guarda();
    }


    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Mensaje WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Mensaje($fila['fecha'], $fila['contenido'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($mensaje)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Mensaje(fecha, contenido) VALUES ('%s', '%s')"
            , $conn->real_escape_string($mensaje->fecha)
            , $conn->real_escape_string($mensaje->contenido)
        );
        if ( $conn->query($query) ) {
            $mensaje->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    
    
    private static function actualiza($mensaje)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Mensaje M SET fecha = '%s', contenido ='%s' WHERE M.id=%d"
            , $conn->real_escape_string($mensaje->fecha)
            , $conn->real_escape_string($mensaje->contenido)
            , $mensaje->id
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borra($mensaje)
    {
        return self::borraPorId($mensaje->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        }
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Mensaje M WHERE M.id = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;
    private $fecha;
    private $contenido;

    private function __construct($fecha, $contenido, $id = null)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->contenido = $contenido;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getContenido()
    {
        return $this->contenido;
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
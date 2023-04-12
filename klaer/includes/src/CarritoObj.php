<?php

namespace es\klaer;

use es\klaer\Aplicacion;

class CarritoObj
{

    
    public static function crea($id, $precio, $nombre, $idUsuario)
    {
        $carritobj = new CarritoObj($id, $precio, $nombre, $idUsuario);
        //echo "SE HA CREADO EL OBJETO CORRECTAMENTE";
        //echo "id: $id | price: $precio | nombre: $nombre | idUser: $idUsuario";
        return $carritobj->guarda();
    }
    
   
    private static function inserta($carritobj)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Carrito(id,precio,nombre,idUsuario) VALUES ('%d', '%d', '%s', '%d')"
            , $conn->real_escape_string($carritobj->id)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->iduser)
        );
        if ( $conn->query($query) ) {
            $carritobj->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function actualiza($carritobj)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Carrito C SET id='%d', precio= '%d, nombre='%s', idUsuario= '%d' WHERE P.id=%d"   
            , $conn->real_escape_string($carritobj->id)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->iduser)
            , $carritobj->id
        );
        
        return $result;
    }
   
   
    
    private static function borra($carritobj)
    {
        return self::borraPorId($carritobj->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        } 
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Carrito C WHERE C.id = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $precio;

    private $nombreProd;    

    private $iduser;

    private function __construct($id = null, $precio, $nombreProd, $iduser)
    {
        $this->id = $id;
        $this->precio = $precio;
        $this->nombreProd = $nombreProd;
        $this->iduser = $iduser;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreProdCarr()
    {
        return $this->nombreProd;
    }

    public function getPriceProdCarr(){
        return $this->precio;
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

<?php

namespace es\klaer;

use es\klaer\Aplicacion;

class CarritoObj
{

    
    public static function crea($idObj, $precio, $nombre, $idUsuario,$cantidad)
    {
        $carritobj = new CarritoObj($idObj, $precio, $nombre, $idUsuario,$cantidad);
      
        return $carritobj->guarda();
    }

    public static function buscaDisponibles()
    {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Carrito");
        $rs = $conn->query($query);
        $result = false;
        $disponibles = [];
        if ($rs) {
           while ($fila = $rs->fetch_assoc()){
                if ($fila) {
                    $result = new CarritoObj($fila['idObj'], $fila['precio'], $fila['nombre'] , $fila['idUsuario'], $fila['cantidad'], $fila['id']);
                    $disponibles[] = $result;
                }
           }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $disponibles;
    }
    
   
    private static function inserta($carritobj)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Carrito(idObj,precio,nombre,idUsuario,cantidad) VALUES ('%d', '%d', '%s', '%d','%d')"
            , $conn->real_escape_string($carritobj->idObj)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->iduser)
            , $conn->real_escape_string($carritobj->cantidad)
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
        $query=sprintf("UPDATE Carrito C SET idObj='%d',precio='%d', nombre= '%s', idUsuario='%d', cantidad='%d' WHERE C.id=%d"   
            , $conn->real_escape_string($carritobj->idObj)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->iduser)
            , $conn->real_escape_string($carritobj->cantidad)
            , $carritobj->id
        );
        
        if ( $conn->query($query) ){
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }
   
    private static function borraCarrito()
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("DROP TABLE Carrito"
        );
        
        if ( $conn->query($query) ){
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }
   
    
    private static function borra($carritobj)
    {
        return self::borraPorId($carritobj->idObj);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        }
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Carrito C WHERE C.idObj = %d"
            , $id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $idObj;

    private $precio;

    private $nombreProd;

    private $iduser;

    private $cantidad;

    private function __construct($idObj, $precio, $nombreProd, $iduser, $cantidad, $id = null)
    {
        $this->idObj = $idObj;
        $this->precio = $precio;
        $this->nombreProd = $nombreProd;
        $this->iduser = $iduser;
        $this->cantidad = $cantidad;
        $this->id = $id;
    }


    public function getIdObj()
    {
        return $this->idObj;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUser(){
        return $this->iduser;
    }

    public function getNombreProd()
    {
        return $this->nombreProd;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function elimina()
    {
        return self::borraCarrito();
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
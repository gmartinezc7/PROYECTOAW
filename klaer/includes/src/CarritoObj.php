<?php

namespace es\klaer;

use es\klaer\Aplicacion;

class CarritoObj
{

    
    public static function crea($nombre, $precio, $descripcion, $tipo, $fecha, $cantidad)
    {
        $carritobj = new CarritoObj($nombre, $precio, $descripcion, $tipo, $fecha, $cantidad);
        return $carritobj->guarda();
    }
    
   
    private static function inserta($carritobj)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Carrito(nombre,precio,descripcion,tipo,fecha,cantidad) VALUES ('%s', '%d', '%s', '%s','%s','%d')"
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->descripcion)
            , $conn->real_escape_string($carritobj->tipo)
            , $conn->real_escape_string($carritobj->fecha)
            , $conn->real_escape_string($carritobj->stock)
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
        $query=sprintf("UPDATE Carrito C SET nombre='%s', precio= '%d, descripcion='%s', tipo= '%s', fecha= '%s',cantidad= '%d' WHERE P.id=%d"   
            , $conn->real_escape_string($carritobj->nombreProd)
            , $conn->real_escape_string($carritobj->precio)
            , $conn->real_escape_string($carritobj->descripcion)
            , $conn->real_escape_string($carritobj->tipo)
            , $conn->real_escape_string($carritobj->fecha)
            , $conn->real_escape_string($carritobj->stock)
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

    private $nombreProd;

    private $precio;

    private $descripcion;

    private $tipo;

    private $fecha;

    private $stock;

    private function __construct($nombreProd, $precio, $descripcion, $tipo, $fecha, $stock, $id = null)
    {
        $this->id = $id;
        $this->nombreProd = $nombreProd;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->fecha = $fecha;
        $this->stock = $stock;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreProd()
    {
        return $this->nombreProd;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getStock()
    {
        return $this->stock;
    }


    public function añadeStock($stock,$idProd)
    {
        $this->stock = $this->stock + $stock;
        self::actualiza($idProd);
    }

    
    public function tieneStock()
    {
        return $this->stock > 0;
    }

    public function reduceStock($stock, $idProd)
    {
        if ($stock <= $this->stock){
            $this->stock = $this->stock - $stock;
        } else {
            $this->stock = 0; // Mensaje de error?
        }
        self::actualiza($idProd);
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

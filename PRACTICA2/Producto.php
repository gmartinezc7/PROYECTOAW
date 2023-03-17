<?php


require_once 'Aplicacion.php';
require_once 'config.php';

class Producto
{

    
    public static function crea($nombre, $precio, $descripcion, $tipo, $fecha, $cantidad)
    {
        $producto = new Producto($nombre, $precio, $descripcion, $tipo, $fecha, $cantidad);
        return $producto->guarda();
    }

    public static function buscaProducto($nombreProd)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Productos P WHERE P.nombre='%s'", $conn->real_escape_string($nombreProd));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'] , $fila['tipo'], $fila['fecha'], $fila['cantidad'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Productos WHERE id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'] , $fila['tipo'], $fila['fecha'], $fila['cantidad'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorTipo($tipo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Productos WHERE tipo=%d AND cantidad > 0", $tipo);
        $productos = [];
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'] , $fila['tipo'], $fila['fecha'], $fila['cantidad'], $fila['id']);
                $productos[] = $result;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $productos;
    }
    
    public static function buscaDisponibles()
    {

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Productos WHERE id> %d", 0);
        $rs = $conn->query($query);
        $result = false;
        $disponibles = [];
        if ($rs) {
           while ($fila = $rs->fetch_assoc()){
                if ($fila) {
                    $result = new Producto($fila['nombre'], $fila['precio'], $fila['descripcion'] , $fila['tipo'], $fila['fecha'], $fila['cantidad'], $fila['id']);
                    $disponibles[] = $result;
                }
           }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $disponibles;
    }
    
   
    private static function inserta($producto)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Productos(nombre,precio,descripcion,tipo,fecha,cantidad) VALUES ('%s', '%d', '%s', '%s','%s','%d')"
            , $conn->real_escape_string($producto->nombreProd)
            , $conn->real_escape_string($producto->precio)
            , $conn->real_escape_string($producto->descripcion)
            , $conn->real_escape_string($producto->tipo)
            , $conn->real_escape_string($producto->fecha)
            , $conn->real_escape_string($producto->stock)
        );
        if ( $conn->query($query) ) {
            $producto->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function actualiza($producto)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Productos P SET nombre='%s', precio= '%d, descripcion='%s', tipo= '%s', fecha= '%s',cantidad= '%d' WHERE P.id=%d"   
            , $conn->real_escape_string($producto->nombreProd)
            , $conn->real_escape_string($producto->precio)
            , $conn->real_escape_string($producto->descripcion)
            , $conn->real_escape_string($producto->tipo)
            , $conn->real_escape_string($producto->fecha)
            , $conn->real_escape_string($producto->stock)
            , $producto->id
        );
        
        return $result;
    }
   
   
    
    private static function borra($producto)
    {
        return self::borraPorId($producto->id);
    }
    
    private static function borraPorId($id)
    {
        if (!$id) {
            return false;
        } 
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Productos P WHERE P.id = %d"
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

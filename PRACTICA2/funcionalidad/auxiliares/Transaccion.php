<?php

class Transaccion
{

    public static function crea($idComprador, $idVendedor, $admin, $idTransaccion, $idProd, $fecha, $cantidad)
    {
        $transaccion = new Transaccion($idComprador, $idVendedor, $admin, $idProd, $fecha, $cantidad, $idTransaccion);
        return $transaccion->guarda();
    }

    private static function inserta($transaccion)
    {
        $obj = Producto::buscaPorId($transaccion->idProd);
        $result = false;

        if ($obj->tieneStock()) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("INSERT INTO Transaccion(idComprador, idVendedor, admin, idProd, fecha, cantidad) VALUES ('%s', '%s', '%s', '%s', '%s','%d')"
                , $conn->real_escape_string($transaccion->idComprador)
                , $conn->real_escape_string($transaccion->idVendedor)
                , $conn->real_escape_string($transaccion->admin)
                , $conn->real_escape_string($transaccion->idProd)
                , $conn->real_escape_string($transaccion->fecha)
                , $conn->real_escape_string($transaccion->cantidad)
            );
            $obj->reduceStock($transaccion->cantidad,$transaccion->idProd);
            $result = true;

            if ( $conn->query($query) ) {
                $transaccion->idTransaccion = $conn->insert_id;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }

        return $result;
        
    }



    private static function actualiza($transaccion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Transaccion T SET idComprador = '%s', idVendedor='%s', admin='%s',idProd='%s',fecha='%s',cantidad='%d' WHERE T.id=%d"
            , $conn->real_escape_string($transaccion->idComprador)
            , $conn->real_escape_string($transaccion->idVendedor)
            , $conn->real_escape_string($transaccion->admin)
            , $conn->real_escape_string($transaccion->idProd)
            , $conn->real_escape_string($transaccion->fecha)
            , $conn->real_escape_string($transaccion->cantidad)
            , $transaccion->idTransaccion
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
        $query = sprintf("SELECT FROM Transaccion T WHERE T.id = %d"
            , $id
        );
        $rs = $conn->query($query);

        if ($rs) {
            $info = $rs->fetch_assoc();
            $obj = Producto::añadeStock($info['cantidad'],$info['idProd']);

            $query = sprintf("DELETE FROM Transaccion T WHERE T.id = %d"
            , $id
            );

            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }

        }
        
        
        return true;
    }


    private $idComprador;

    private $idVendedor;

    private $admin;

    private $idTransaccion;

    private $idProd;

    private $fecha;

    private $cantidad;

    private function __construct($idComprador, $idVendedor, $admin, $idProd, $fecha, $cantidad, $idTransaccion = null)
    {
        $this->idComprador = $idComprador;
        $this->idVendedor = $idVendedor;
        $this->admin = $admin;
        $this->idTransaccion = $idTransaccion;
        $this->idProd = $idProd;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
    }

    public function getIdComprador()
    {
        return $this->idComprador;
    }

    public function getIdVendedor()
    {
        return $this->idVendedor;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getIdCompra()
    {
        return $this->idTransaccion;
    }

    public function getIdProd()
    {
        return $this->idProd;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function guarda()
    {
        if ($this->idTransaccion !== null) {
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
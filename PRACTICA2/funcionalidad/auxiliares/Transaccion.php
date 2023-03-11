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
            $obj->reduceStock($transaccion->cantidad);
            $result = true;

            if ( $conn->query($query) ) {
                $transaccion->idTransaccion = $conn->insert_id;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }

        return $result;
        
    }


    /**
     * 
     * 
     *      TERMINAR 
     */
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Transaccion T SET nombreUsuario = '%s', nombre='%s', password='%s' WHERE T.id=%d"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string($usuario->direccion)
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            $result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
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
}
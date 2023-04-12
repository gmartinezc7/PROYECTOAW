<?php

namespace es\klaer;

use es\klaer\Aplicacion;

class Respuesta {

    public $id;
    public $usuario;
    public $texto;
    public $fecha;
    public $idPub;

    public function __construct($id, $usuario, $texto, $fecha, $idPub){
        $this->id=$id;
        $this->usuario=$usuario;
        $this->texto=$texto;
        $this->fecha=$fecha;
        $this->idPub=$idPub;
    }

    public static function crea($id, $usuario, $texto, $fecha, $idPub) {
        $res = new Respuesta($id, $usuario, $texto, $fecha, $idPub);
        return $res->guarda($res);
    }

    public function guarda($res){
        if($this->id !=null){
            return self::actualiza($res);
        }
        return self::inserta($res);
    }

    private static function inserta($res){
        $conn=Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO respuestas(idUsuario, texto, fecha, idPub) VALUES ('%s', '%d', '%s', '%d')"
        ,$conn->real_escape_string($res->usuario)
        ,$conn->real_escape_string($res->texto)
        ,$conn->real_escape_string($res->fecha)
        ,$conn->real_escape_string($res->idPub));
        if ( $conn->query($query) ) {
            $res->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $res;
    }

    //NO SE SI TENEMOS TABLA RESPUESTA PARA ACTUALIZAR
    public static function actualiza($res){
        $result = false;
        //$app = Aplicacion::getInstancia();
        //$conn = $app->conexionBd();
        $conn=Aplicacion::getInstance()->getConexionBd();

        $query=sprintf("UPDATE respuestas U SET id = '%d', idUsuario='%d', texto='%s', fecha='%s', idPub='%d' WHERE U.id=%d"
            , $conn->real_escape_string($res->id)
            , $conn->real_escape_string($res->usuario)
            , $conn->real_escape_string($res->texto)
            , $conn->real_escape_string($res->fecha)
            , $conn->real_escape_string($res->idPub)
            , $res->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la respuesta: " . $res->id;
            }
            else{
                $result = $res;
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        
        return $result;
    }

    //NO SE SI TENEMOS TABLA RESPUESTA PARA BUSCAR
    public static function buscaRespuesta($id){
        //$app=Aplicacion::getInstancia();
        //$conn=$app->conexionBD();
        $conn=Aplicacion::getInstance()->getConexionBd();

        $query=sprintf("SELECT * FROM respuestas WHERE id='%d'"
        ,$conn->real_escape_string($id));
        $rs=$conn->query($query);
        $result=false;
        if($rs){
            if($rs->num_rows==1){
                $fila=$rs->fetch_assoc();
                $res=new Respuesta($fila['id'], $fila['idUsuario'], $fila['texto'], $fila['fecha'], $fila['idPub']);
                $result=$res;
            }
            $rs->free();
        }else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function cargarRespuesta($id){
      $conn=Aplicacion::getInstance()->getConexionBd();
      $sql = sprintf("SELECT * FROM respuestas WHERE idPub='%s'"
        , $conn->real_escape_string($id));
      $result = $conn->query($sql);
        return $result;
    }

    public static function borrarRespuesta($id){
        $res=self::buscaRespuesta($id);
        $result=false;
        if(!$res){
            return $result;
        }else{
            $conn=Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("DELETE FROM respuestas WHERE id='%s'"
            ,$conn->real_escape_string($id));
            if ( $conn->query($query) ) {
                if ( $conn->affected_rows != 1) {
                    echo "No se ha podido borrar el producto: " . $res->id;
                }
                else{
                    $result =true;
                }
            } else {
                echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            }
            
            return $result;
        }
    }

    
    public function getId(){
        return $this->id;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getTexto(){
        return $this->texto;
    }

    public function getIdPub(){
        return $this->idPub;
    }

    public function setUsuario($usuario){
        $this->usuario=$usuario;
        self::guarda($this);
    }

    public function setFecha($fecha){
        $this->fecha=$fecha;
        self::guarda($this);
    }

    public function setTexto($texto){
        $this->texto=$texto;
        self::guarda($this);
    }

    public function setIdPub($idPub){
        $this->idPub=$idPub;
        self::guarda($this);
    }
}
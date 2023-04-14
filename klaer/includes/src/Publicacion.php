<?php

namespace es\klaer;

use es\klaer\Aplicacion;

class Publicacion {

    private $id;
    private $titulo;
    private $idUsuario;
    private $mensaje;
    private $respuestas;
    private $fecha;

    private function __construct($id, $titulo, $idUsuario, $mensaje, $respuestas, $fecha) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->idUsuario = $idUsuario;
        $this->mensaje = $mensaje;
        $this->respuestas = $respuestas;
        $this->fecha = $fecha;
    }

    public static function crea($id, $titulo, $idUsuario, $mensaje, $respuestas, $fecha) {
        $pub = new Publicacion($id, $titulo, $idUsuario, $mensaje, $respuestas, $fecha);
        return $pub->guarda($pub);
    }

    public function guarda($pub){
        if($this->id !=null){
            return self::actualiza($pub);
        }
        return self::inserta($pub);
    }

    private static function inserta($pub){
        $conn=Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO foro(titulo, idUsuario, mensaje, respuestas, fecha) VALUES ('%s', '%d', '%s', '%d', '%s')"
        ,$conn->real_escape_string($pub->titulo)
        ,$conn->real_escape_string($pub->idUsuario)
        ,$conn->real_escape_string($pub->mensaje)
        ,$conn->real_escape_string($pub->respuestas)
        ,$conn->real_escape_string($pub->fecha));
        if ( $conn->query($query) ) {
            $pub->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $pub;
    }

    private static function actualiza($pub){
        $result = false;
        $conn=Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE foro U SET id = '%d', titulo='%s', idUsuario='%d', mensaje='%s', respuestas='%d', fecha='%s' WHERE U.id=%d"
            , $conn->real_escape_string($pub->id)
            , $conn->real_escape_string($pub->titulo)
            , $conn->real_escape_string($pub->userid)
            , $conn->real_escape_string($pub->mensaje)
            , $conn->real_escape_string($pub->respuestas)
            , $conn->real_escape_string($pub->fecha)
            , $pub->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la publicacion: " . $pub->id;
            }
            else{
                $result = $pub;
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        
        return $result;
    }

    public static function buscaPub($id){
        $conn=Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("SELECT * FROM foro WHERE id='%s'"
        ,$conn->real_escape_string($id));
        $rs=$conn->query($query);
        $result=false;
        if($rs){
            if($rs->num_rows==1){
                $fila=$rs->fetch_assoc();
                $pub=new Publicacion($fila['id'],$fila['titulo'], $fila['idUsuario'], $fila['mensaje'], $fila['respuestas'], $fila['fecha']);
                $result=$pub;
            }else{
                echo 'No se han podido cargar las publicaciones';
            }
            $rs->free();
        }else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function cargarPub(){
        $conn=Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM foro";
       $result = $conn->query($sql);

        return $result;
    }

    public static function borrarPub($id){
        $pub=self::buscaPub($id);
        $result=false;
        if(!$pub){
            return $result;
        }else{
            $conn=Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("DELETE FROM foro WHERE id='%d'"
            ,$conn->real_escape_string($id));
            if ( $conn->query($query) ) {
                if ( $conn->affected_rows != 1) {
                    echo "No se ha podido borrar la publicacion: " . $pub->id;
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

    public static function modificarNumeroRespuestas($id, $r) {
        $pub=self::buscaPub($id);
        $result=false;
        if(!$pub){
            return $result;
        }else{
            $conn=Aplicacion::getInstance()->getConexionBd();
            $query=sprintf("UPDATE foro SET respuestas = respuestas + $r where id ='%d'"
            , $conn->real_escape_string($id));
    
            if ($conn->query($query) === TRUE){
                    $app = Aplicacion::getInstance();                
                    $mensajes = ['Cambios guardados con éxito!'];
                    $app->putAtributoPeticion('mensajes', $mensajes);
            } else {
                    echo"Error en : " . $query . "<br>" . $conn->error;
                    exit();
            }
            return true;
        }
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }
    
    public function getMensaje(){
        return $this->mensaje;
    }
            
    public function getRespuestas(){
        return $this->respuestas;
    }
    
    public function getFecha(){
        return $this->fecha;
    }
    
    public function setTitulo($titulo){
        $this->titulo=$titulo;
        self::guarda($this);
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario=$idUsuario;
        self::guarda($this);
    }

    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
        self::guarda($this);
    }
    
    public function setRespuestas($respuestas){
        $this->respuestas=$respuestas;
        self::guarda($this);
    }
    
    public function setFecha($fecha){
        $this->fecha=$fecha;
        self::guarda($this);
    }
}


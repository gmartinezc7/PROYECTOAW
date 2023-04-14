<?php
  require_once __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;

  $tituloPagina = 'Respuesta';
  
  $contenidoPrincipal=<<<EOS
      <h1>Contenido de las respuestas</h1>
  EOS;

    $erroresFormulario = array();

    $texto = isset($_POST['texto_respuesta']) ? $_POST['texto_respuesta'] : null;

    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
      if ( empty($texto) ) {
        $contenidoPrincipal.=<<<EOS
        <p> El comentario no puede estar vacío </p>
        EOS;
      }
      else {
        $id = $_GET['id']; //id de la publicion
        $idUsuario = $_SESSION['idUsuario']; //id del usuario
        $fecha=date('Y-m-d h-i-s', time());

  
        $respuesta=Respuesta::crea(null,$idUsuario,$texto,$fecha,$id);
        if($respuesta){
          $contenidoPrincipal.= <<<EOS
          <p> Has respondido </br> <a href= "verPublicacion.php? id=$id"> Volver a la publicacion</a></p>
          EOS;

          $numerorespuestas=Publicacion::modificarNumeroRespuestas($id, 1);
        }
      }
    } else {
      $contenidoPrincipal.=<<<EOS
          <p> No puedes responder porque no estás registrado<br>
          Usuario desconocido. <a href='login.php'>Inicie sesión</a> o
        <a href='registro.php'>regístrese</a> para continuar. </p>
      EOS;
    }
 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
?>
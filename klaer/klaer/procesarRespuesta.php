<?php
  //require_once("includes/config.php");
  //HAY QUE PONER BIEN LOS INCLUDES
  require_once __DIR__.'/includes/config.php';
  require __DIR__. '/includes/src/Respuesta.php';
  require __DIR__. '/includes/src/Publicacion.php';
  require __DIR__. '/includes/src/usuarios/Usuario.php';

  $tituloPagina = 'Respuesta';
  //$conn = $app->conexionBD();
  
  //No me gusta tener aqui las css
  $contenidoPrincipal=<<<EOS
      <h1>Contenido de las respuestas</h1>
  EOS;

    $erroresFormulario = array();

    //$conn = $GLOBALS['conn'];
    $texto = isset($_POST['texto_respuesta']) ? $_POST['texto_respuesta'] : null;
    $publicacion= isset($GET['nombre']); //dudita
    if ( empty($texto) ) {
        $erroresFormulario[] = "El comentario no puede estar vacío";
    }

    $id = $_GET['id']; //id de la publicion
    $user = $_SESSION['nombreUsuario'];
    $usuario = Usuario::buscaUsuario($user);
    $idUsuario = $usuario->getId();

    $fecha=date('Y-m-d h-i-s', time());

    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
      $respuesta=Respuesta::crea(null,$idUsuario,$texto,$fecha,$id);
      if($respuesta){
        $GLOBALS["contenido"] .= <<<EOS
        <p> Has respondido </br> <a href= "verTema.php? id=$id"> Volver al tema</a></p>
        EOS;
        $numerorespuestas=Publicacion::modificarNumeroRespuestas($id, 1);
      }
    } else {
      $contenido.=<<<EOS
          <p class="noRegMsg"> No puedes responder porque no estás registrado<br>
          Usuario desconocido. <a href='login.php'>Inicie sesión</a> o
        <a href='registro.php'>registrese</a> para continuar. </p>
      EOS;
    }
 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
?>
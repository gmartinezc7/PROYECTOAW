<?php
require __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;
use es\klaer\usuarios\Usuario;

$tituloPagina = 'Comentarios';
$contenidoPrincipal = <<<EOS
  <p><a href="foro.php"> Volver al foro</a></p>
EOS;

$id = $_GET['id'];
$result=Publicacion::buscaPub($id);

if($result){
    $title=$result->getTitulo();

    $idCreador = Usuario::buscaPorId($result->getIdUsuario());
    $creador = $idCreador->getUsuario();
    
    $fecha=$result->getFecha();
    $comentario=$result->getMensaje();

    $contenidoPrincipal.=<<<EOS
    <h1> $title </h1> <br>
        <table id="table">
        <tr>
            <td><p>Creado por $creador - $fecha </p></td>
        </tr>
        <tr>
            <td><p>$comentario</p></td>
        </tr>
        
    EOS;

    $respuestas=Respuesta::cargarRespuesta($id);
    while($row= $respuestas->fetch_assoc()){
        $idRespuesta = $row['id'];

        $usuario = $row['idUsuario'];
        $idUsuario = Usuario::buscaPorId($usuario);
        $nombreUsuario = $idUsuario->getUsuario();

        $texto = $row['texto'];
        $fechaR = $row['fecha'];
        $contenidoPrincipal.=<<<EOS
        <tr>
          <td>
          <p>Re: $nombreUsuario - $fechaR</p>
          </td>
        </tr>
      EOS;

      // DERECHOS DE MODERADOR
      if($app->tieneRol(Usuario::MOD_ROLE)){
        $contenidoPrincipal.=<<<EOS
          <tr>
            <td>$texto</td>
          
            <td class="button">
            <form class="botones" action = "editar.php?idR=$idRespuesta" method="post">
            <input type="submit" name='editarRespuesta' value = "Editar"/>
            </form>  
            <form class="botones" action = "eliminar.php?idR=$idRespuesta" method="post">
            <input type="submit" name='eliminarRespuesta' value = "Eliminar"/>
            </form>
            </td>
          </tr>
        EOS; 
      }
      else{
        $contenidoPrincipal.=<<<EOS
          <tr>
            <td><p>$texto</p></td>
          </tr>
        EOS; 
      }
    }

    $respuestas->free();


    $contenidoPrincipal.=<<<EOS
        </table>
    EOS;
}

else {
    $contenidoPrincipal.=<<<EOS
        <p> Todavia no hay publicaciones</p>
    EOS;
}

$contenidoPrincipal.=<<<EOS
    <form action = "procesarRespuesta.php?id=$id" method="post">
    Escribe aqui tu respuesta: <input type="text" name="texto_respuesta" />
    <input type="submit" name='Respuesta' value = "Responder"/>
    </form>
  EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
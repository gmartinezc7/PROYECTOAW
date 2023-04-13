<?php
require __DIR__.'/includes/config.php';
require __DIR__. '/includes/src/Publicacion.php';
require __DIR__. '/includes/src/Respuesta.php';

//$conn = $app->conexionBD();

$tituloPagina = 'Comentarios';
$contenidoPrincipal=<<<EOS
    <h1> NO SE QUE PONER AQUI </h1>
EOS;

$id = $_GET['id'];
$result=es\klaer\Publicacion::buscaPub($id);

if($result){
    $title=$result->getTitulo();
    $creador=$result->getIdUsuario();
    $fecha=$result->getFecha();
    $comentario=$result->getMensaje();

    $contenidoPrincipal.=<<<EOS
    <h2> $title </h2> <br>
        <table id="table">
        <tr>
            <td><p>Creado por $creador - $fecha </p></td>
        </tr>
        <tr>
            <td><p>$comentario</p></td>
        </tr>
        
    EOS;

    $respuestas=es\klaer\Respuesta::cargarRespuesta($id);
    while($row= $respuestas->fetch_assoc()){
        $idRespuesta = $row['id'];
        $usuario = $row['idUsuario'];
        $texto = $row['texto'];
        $fechaR = $row['fecha'];
        $contenidoPrincipal.=<<<EOS
        <tr>
          <td>
          <p>Re: $usuario - $fechaR</p>
          </td>
        </tr>
      EOS;

      /*if($usuario ==$_SESSION['nombreUsuario']|| (isset($_SESSION['esAdmin'])&&$_SESSION['esAdmin'])){
        $contenido.=<<<EOS
          <tr>
            <td class="msg">$texto</td>
          
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
        $contenido.=<<<EOS
          <tr>
            <td class="msg"><p>$texto</p></td>
          </tr>
        EOS; 
      }*/

      $contenidoPrincipal.=<<<EOS
      <tr>
        <td>
        <p>$texto</p>
        </td>
      </tr>
    EOS;

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
<?php

require __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;

$tituloPagina = 'ProcesarEditar';
$contenidoPrincipal=<<<EOS
    <h1> PROCESO </h1>
EOS;

if (isset($_POST['editaRespuesta'])) {
    $idRespuesta = $_GET['idR'];
    $texto = isset($_POST['textoRespuesta']) ? $_POST['textoRespuesta'] : null;
    $respuesta = Respuesta::buscaRespuesta($idRespuesta);

    if(!empty($texto) && $respuesta->getTexto() != $texto){
        $respuesta->setTexto($texto);
        $idPub = $respuesta->getIdPub();
        header("Location: verPublicacion.php?id=$idPub");
    }
   /* $contenidoPrincipal=<<<EOS
    <p> Has Editado </br> <a href= "verPublicacion.php? id=$idPub"> Volver a la publicacion</a></p>
    EOS;
    */
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
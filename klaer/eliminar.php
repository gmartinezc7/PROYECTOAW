<?php

require __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;

$tituloPagina = 'Eliminar';
$contenidoPrincipal=<<<EOS
    <h1> ELIMINAR RESPUESTA </h1>
EOS;

if (isset($_POST['eliminarRespuesta'])){
    $idRespuesta = $_GET['idR'];
    $respuesta = Respuesta::buscaRespuesta($idRespuesta);
    $idPublicacion = $respuesta->getIdPub();
    Respuesta::borrarRespuesta($idRespuesta);
    Publicacion::modificarNumeroRespuestas($idPublicacion, -1);
 
    header("Location: verPublicacion.php?id=$idPublicacion");
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
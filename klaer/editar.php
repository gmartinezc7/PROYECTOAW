<?php

require __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;

$tituloPagina = 'Editar';
$contenidoPrincipal=<<<EOS
    <h1> EDITAR RESPUESTA </h1>
EOS;

if (isset($_POST['editarRespuesta'])){
    $id =  $_GET['idR'];
    $respuesta = Respuesta::buscaRespuesta($id);
    if(!empty($respuesta)){
        $texto = $respuesta->getTexto();

        $contenidoPrincipal.=<<<EOS
        <h3>Editar respuesta</h3>
        <form action="procesarEditar.php?idR=$id" method="POST">
        <fieldset>
            <legend>Datos respuesta </legend>
            <label>Comentario:</label> <input type="text" name="textoRespuesta" value ="$texto"/>
            <br/>
            <br/>
            <button type="submit" name="editaRespuesta">Guardar</button>
        </fieldset>
        </form>
        EOS;
    }
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
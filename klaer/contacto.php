<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina="Contacto";

$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../../../css/estilo.css' />
	<h1>¿Quiénes somos?</h1>
    <div class="contenedor"> 
        <div class="contenido"> 
            <h2> Administrador</h2> 
                <p> Explicación admin </p> 
        </div>
        <div class="contenido"> 
            <h2> Director de marketing </h2> 
                <p> Explicacion director de marketing</p> 
        </div>
        <div class="contenido"> 
            <h2> Social Manager</h2> 
                <p> Explicación social manager </p> 
        </div>
    </div>

EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);

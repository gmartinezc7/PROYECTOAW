<?php
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Contacto';
$inicio = true;


$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
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

require 'comun/lobby.php';

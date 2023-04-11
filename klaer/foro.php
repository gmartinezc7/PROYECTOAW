<?php
require_once __DIR__.'/../../config.php';

/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Foro';

$contenidoPrincipal=<<<EOS
	<link rel="stylesheet" type="text/css" href='../../../css/estilo.css' />
	<h1>Contenido del foro</h1>
	<p> Las nuevas Nike Tiburon.</p>
EOS;


//require 'comun/lobby.php';
require __DIR__.'/../plantillas/lobby.php';

<?php
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Foro';
$inicio = true;

$contenidoPrincipal=<<<EOS
	<link rel="stylesheet" type="text/css" href='../css/estilo.css' />
	<h1>Contenido del foro</h1>
	<p> Las nuevas Nike Tiburon.</p>
EOS;


require 'comun/lobby.php';

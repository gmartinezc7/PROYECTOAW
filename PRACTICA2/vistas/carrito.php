<?php
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Carrito';
$inicio = true;

$contenidoPrincipal=<<<EOS
	<link rel="stylesheet" type="text/css" href='../css/estilo.css' />
	<h1>CARRITO</h1>
	<p> Carrito de compra de usuario logueado, si no hay usuario logueado, no se muestra</p>
EOS;


require 'comun/lobby.php';

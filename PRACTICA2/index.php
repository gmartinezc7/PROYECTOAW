<?php

require_once 'config.php';

$tituloPagina = 'Portada';
$inicio = false;

$contenidoPrincipal=<<<EOS
<link rel="stylesheet" type="text/css" href='css/estilo.css' />

<h1>Página principal</h1>
	<p> PÁGINA DE INICIO DE KLAER </p>
EOS;

require 'vistas/comun/lobby.php';

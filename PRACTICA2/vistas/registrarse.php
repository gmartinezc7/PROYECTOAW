<?php

require_once '../config.php';
require_once '../FormularioRegistro.php';

$tituloPagina = 'Registro';
$inicio = true;

$form = new FormularioRegistro(""); 
$htmlFormRegistro = $form->gestiona();

$contenidoPrincipal = <<<EOS
	<h1>Registro de usuario</h1>
	$htmlFormRegistro
EOS;

require 'comun/lobby.php';

<?php

require_once '../config.php';
require_once '../FormularioRegistro.php';

$tituloPagina = 'Registro';
$inicio = true;

$form = new FormularioRegistro(""); 
$form->gestiona();
$formulario = $form->generaFormulario();

$contenidoPrincipal = <<<EOS
	<h1>Registro de usuario</h1>
	$formulario
EOS;

require 'comun/lobby.php';

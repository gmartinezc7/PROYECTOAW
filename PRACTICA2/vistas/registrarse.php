<?php

require_once '/config.php';
require_once '../FormularioRegistro.php';

$tituloPagina = 'Registro';

$form = new FormularioRegistro(""); 
$form->gestiona();
$formulario = $form->generaFormulario();

$contenidoPrincipal = <<<EOS
	<h1>Registro de usuario</h1>
	$formulario
EOS;

require 'vistas/comun/lobby.php';
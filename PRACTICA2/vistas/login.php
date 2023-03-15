<?php

require_once '../config.php';
require_once '../FormularioLogin.php';

$tituloPagina = 'Login';

$form = new FormularioLogin("login.php"); 
$form->gestiona();
$formulario = $form->generaFormulario();

$contenidoPrincipal = <<<EOS
	<h1>Acceso al sistema</h1>
	$formulario
EOS;

require 'vistas/comun/lobby.php';
<?php

require_once '../config.php';
require_once '../FormularioLogin.php';

$tituloPagina = 'Login';
$inicio = true;

$form = new FormularioLogin("login.php"); 
$form->gestiona();
$formulario = $form->generaFormulario();

$contenidoPrincipal = <<<EOS
	<h1>Acceso al sistema</h1>
	$formulario
EOS;

require __DIR__.'/comun/lobby.php';
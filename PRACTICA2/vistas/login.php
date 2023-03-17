<?php

require_once '../config.php';
require_once '../FormularioLogin.php';
require_once '../Formulario.php';

$tituloPagina = 'Login';
$inicio = true;

$form = new FormularioLogin("login.php"); 
$htmlFormLogin = $form->gestiona();
//$formulario = $form->generaFormulario();

$contenidoPrincipal = <<<EOS
	<h1>Acceso al sistema</h1>
	$htmlFormLogin
EOS;

require __DIR__.'/comun/lobby.php';

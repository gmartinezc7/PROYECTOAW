<?php

//Inicio del procesamiento
require_once '../config.php';

//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["nombre"]);


session_destroy();
session_start();
$tituloPagina = 'Logout';
$contenidoPrincipal = <<<EOF
		<h1>Hasta pronto!</h1>
EOF;

require __DIR__.'/comun/lobby.php';

<?php

require_once 'config.php';

$tituloPagina = 'Portada';
$inicio = false;



$dni = '45678903';
//Conexion con base de datos
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);


$contenidoPrincipal=<<<EOS
	<link rel="stylesheet" type="text/css" href='css/estilo.css' />
	<p>**Conectando con la base de datos**</p>
	<h1>Página principal</h1>
	<p> PÁGINA DE INICIO DE KLAER </p>
EOS;
if ($conn->connect_error){
    die("La conexión ha fallado" . $conn->connect_error);
}else $contenidoPrincipal .= '<p>***La conexión es correcta***</p>';

$conn->close();
$contenidoPrincipal .= '<p>**Cerrando la conexión**</p>';


require 'vistas/comun/lobby.php';

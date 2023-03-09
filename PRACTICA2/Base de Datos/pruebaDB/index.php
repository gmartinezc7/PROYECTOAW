<?php
//Definicion de constantes
//Parametros de acceso de la base de datos
define('BD_HOST', 'localhost');
define('BD_USER', 'klaer');
define('BD_PASS', 'klaer');
define('BD_NAME', 'klaer');

$tituloPagina = 'Datos';
$contenidoPie = 'No hay errores';
$contenidoPrincipal = '<p>**Conectando con la base de datos**</p>';
$dni = '45678903';
//Conexion con base de datos
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
if ($conn->connect_error){
    die("La conexión ha fallado" . $conn->connect_error);
}
$contenidoPrincipal .= '<p>***La conexión es correcta***</p>';
$conn->close();
$contenidoPrincipal .= '<p>**Cerrando la conexión**</p>';

include __DIR__.'/includes/plantillas/plantilla.php';
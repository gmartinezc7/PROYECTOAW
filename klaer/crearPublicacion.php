<?php

require __DIR__.'/includes/config.php';

use es\klaer\Respuesta;
use es\klaer\Publicacion;
use es\klaer\usuarios\Usuario;

$tituloPagina = 'CrearPublicacion';
$contenidoPrincipal=<<<EOS
    <h1> LA CREACION </h1>
EOS;

$titulo = isset($_POST['titulo_pub']) ? $_POST['titulo_pub'] : null;
$mensaje = isset($_POST['comentario']) ? $_POST['comentario'] : null;
$fecha=date('Y-m-d h-i-s', time());

if (empty($titulo)||empty($mensaje)) {
    $contenidoPrincipal.= <<<EOS
    <p>El titulo y el comentario no pueden estar vacíos</p>
    EOS;
}
else {
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $idUsuario = $_SESSION['idUsuario'];
        $pub=Publicacion::crea(null, $titulo, $idUsuario, $mensaje, 0, $fecha);
         if ($pub){
            $contenidoPrincipal.= <<<EOS
                 <p> Publicacion creada </br> <a href= "foro.php"> Volver al Foro</a> </p>
             EOS;
         }
    }
    else {
        $contenidoPrincipal.=<<<EOS
            <p> No puedes crear un tema porque no estás registrado<br/>
            Usuario desconocido. <a href='login.php'>Inicie sesión</a> o
            <a href='registro.php'>regístrese</a> para continuar. </p>
        EOS;
    }
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
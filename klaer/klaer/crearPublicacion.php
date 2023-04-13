<?php

require __DIR__.'/includes/config.php';
require __DIR__. '/includes/src/Publicacion.php';
require __DIR__. '/includes/src/usuarios/Usuario.php';

//$conn = $app->conexionBD();

$tituloPagina = 'CrearPublicacion';
$contenidoPrincipal=<<<EOS
    <h1> LA CREACION </h1>
EOS;

$titulo = isset($_POST['titulo_tema']) ? $_POST['titulo_tema'] : null;
$mensaje = isset($_POST['comentario']) ? $_POST['comentario'] : null;
$fecha=date('Y-m-d h-i-s', time());

if (empty($titulo)||empty($comentario)) {
    $contenidoPrincipal.= <<<EOS
    <p>El titulo y el comentario no pueden estar vacíos</p>
    EOS;
}
else {
    $user = $_SESSION['usuario'];
    $usuario = es\klaer\usuarios\Usuario::buscaUsuario($user);
    $idUsuario = $usuario->getId();
}

if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
    $pub=es\klaer\Publicacion::crea(null, $titulo, $idUsuario, $mensaje, 0, $fecha);
     if ($pub){
        $contenidoPrincipal.= <<<EOS
             <p> Publicacion creada </br> <a href= "/includes/vistas/helpers/foro.php"> Volver al Foro</a> </p>
         EOS;
     }
}
else {
    $contenido.=<<<EOS
        <p class="noRegMsg"> No puedes crear un tema porque no estás registrado<br/>
        Usuario desconocido. <a href='login.php'>Inicie sesión</a> o
        <a href='registro.php'>registrese</a> para continuar. </p>
    EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
<?php
//require_once __DIR__.'/../../config.php';
//require_once __DIR__ . '/comprar.php';

require_once __DIR__.'/includes/config.php';
use es\klaer\CarritoObj;

$tituloPagina = 'Carrito';
$contenidoPrincipal = '';


function buildFromCarrito(){
    $codigohtml='';
    $busquedaCarrito = CarritoObj::buscaDisponibles();
    $objCarritoSerial = base64_encode(serialize($busquedaCarrito));
    $i=0;

    $precioTotal = 0;

    foreach ($busquedaCarrito as $objcarrito){
        $idObj = $objcarrito->getIdObj();
        $precio = $objcarrito->getPrecio();
        $cantidad = $objcarrito->getCantidad();
        $nombreProd = $objcarrito->getNombreProd();
        $idUser = $objcarrito->getIdUser();

        $aux = $precio * $cantidad;
        $codigohtml .= <<<EOS
        <p> Nombre: $nombreProd Cantidad: $cantidad Precio: $aux </p>
        EOS;

        $precioTotal += $aux;

    }

    $codigohtml .= <<<EOS
        <p> Precio total: $precioTotal </p>
        EOS;

    return $codigohtml;
}







if ($app->usuarioLogueado()){
    $elemsCarrito = buildFromCarrito();
    $contenidoPrincipal = <<<EOS
    <h1>CARRITO</h1>
    $elemsCarrito
    EOS;

}else{
    $contenidoPrincipal = <<<EOF
    <p> Hace falta estar logeado para observar el carrito </p>
    EOF;
}

//require 'comun/lobby.php';
//require __DIR__.'/../plantillas/lobby.php';
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);

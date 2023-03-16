<?php


$tituloPagina = 'Carrito';
$inicio = true;

//session_start();
$codigohtml2 = '';

if(isset($_SESSION['usuario'])){
    $contenidoPrincipal = <<<EOF
    <p> Productos añadido(s) al carrito </p>
    EOF;

    if(isset($_POST['botonComprar'])){
        $i = $_POST['indice'];
        $productos = unserialize($_POST['prod']);

        $prod_carrito = $productos[$i];
        $nombre = $prod_carrito->getNombreProd();
        $descripcion = $prod_carrito->getDescripcion();
        $tipo = $prod_carrito->getNombreProd();
        $fecha = $prod_carrito->getFecha();
        $stock = $prod_carrito->getStock();

        $contenidoPrincipal .= <<<EOF
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock </p>
        EOF;
		echo "hola prueba de carrito22222s";
    }
} else {
    $contenidoPrincipal = <<<EOF
    <p> Hace falta estar logeado para observar el carrito </p>
    EOF;
}

require 'comun/lobby.php';
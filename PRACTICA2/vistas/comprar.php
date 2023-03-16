<?php

require '../Producto.php';
//require ("./comun/pie.php"); 
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Página de Compras';
$inicio = true;


$busquedaFor = buildFormProds();
$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
	<h1>COMPRAR</h1>
    $busquedaFor
EOS;



function buildFormProds(){
    $codigohtml = '';
    $busquedaProductos = Producto::buscaDisponibles();
    foreach($busquedaProductos as $producto){

        $nombre = $producto->getNombreProd();
        $descripcion = $producto->getDescripcion();
        $tipo = $producto->getNombreProd();
        $fecha = $producto->getFecha();
        $stock = $producto->getStock();

        
       
        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock</p>
        EOS;
        

        


    }

    return $codigohtml;

}






require 'comun/lobby.php';

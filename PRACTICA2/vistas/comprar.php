

<?php

require '../Producto.php';
//require ("./comun/pie.php"); 
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Página de Compras';
$inicio = true;




$codigohtml;


$busquedaFor = buildFormProds();
$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
	<h1>COMPRAR</h1>
    $busquedaFor
EOS;



function buildFormProds(){
    //$codigohtml = 'hola';
    $busquedaProductos = Producto::buscaDisponibles();
    foreach($producto as $busquedaProductos){

        $nombre = $producto.getNombreProd();
        $descripcion = $producto.getDescripcion();
        $tipo = $producto.getNombreProd();
        $fecha = $producto.getFecha();
        $stock = $producto.getStock();

        
       
        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion </p>
        EOS;
        

        


    }

    return $codigohtml;

}






require 'comun/lobby.php';

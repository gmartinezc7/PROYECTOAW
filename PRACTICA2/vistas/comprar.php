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
    $prodsSerializado = serialize($busquedaProductos);
    $i=0;
    foreach($busquedaProductos as $producto){



        $nombre = $producto->getNombreProd();
        $descripcion = $producto->getDescripcion();
        $tipo = $producto->getNombreProd();
        $fecha = $producto->getFecha();
        $stock = $producto->getStock();


        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock </p>
        <input type="hidden" name="prod" value="<?= htmlentities($prodsSerializado) ?">
        <input type="hidden" name="indice" value="<?php echo $i; ?>">
        <form action="comprar.php" class="form-container" method="POST">
        <div><button type="submit" name="botonComprar">Comprar</button></div>
        EOS;
        
        ++$i;
    }

    return $codigohtml;

}

   



require 'comun/lobby.php';

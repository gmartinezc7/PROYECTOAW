<?php
require_once __DIR__.'/includes/config.php';

use es\klaer\Producto;

$tituloPagina = 'Página de Compras';
$contenidoPrincipal='';


function buildFormProds(){
    $codigohtml = '';
    $busquedaProductos = Producto::buscaDisponibles();
    $prodsSerializado = base64_encode(serialize($busquedaProductos));
    $i=0;
    foreach($busquedaProductos as $producto){
        $nombre = $producto->getNombreProd();
        $descripcion = $producto->getDescripcion();
        $tipo = $producto->getNombreProd();
        $fecha = $producto->getFecha();
        $stock = $producto->getStock();


        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock </p>       
        <form action="comprar.php" class="form-container" method="POST">
        <input type="hidden" name="prod" value='$prodsSerializado'>
        <input type="hidden" name="indice" value="$i">
        <div><button type="submit" name="botonComprar">Comprar</button></div>
        </form>
EOS;

        ++$i;
    }

    return $codigohtml;

}

if ($app->usuarioLogueado()) {
	$busquedaFor = buildFormProds();
	$contenidoPrincipal=<<<EOS
	<h1>COMPRAR</h1>
	$busquedaFor
	EOS;

} else {
  $contenidoPrincipal=<<<EOS
    <h1>Usuario no registrado!</h1>
    <p>Debes iniciar sesión para ver el contenido.</p>
  EOS;

}



if (isset($_POST['botonComprar'])){
  if (isset($_POST[$nombre])){
    
  }

}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
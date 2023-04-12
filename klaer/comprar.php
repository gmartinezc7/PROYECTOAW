<?php
require_once __DIR__.'/includes/config.php';

use es\klaer\CarritoObj;
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
        $id = $producto->getId();
        $descripcion = $producto->getDescripcion();
        $tipo = $producto->getNombreProd();
        $fecha = $producto->getFecha();
        $stock = $producto->getStock();
        $price = $producto->getPrice();
        $idUser = $producto->getIdUser();


        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock | PRECIO: $price </p>       
        <form action="comprar.php" class="form-container" method="POST">
        <input type="hidden" name="prod" value='$prodsSerializado'>
        <input type="hidden" name="indice" value="$i">
        <div><button type="submit" name="botonComprar" onClick="disabled" >Comprar</button></div>
        </form>
EOS;

        ++$i;

        if (isset($_POST['botonComprar'])){
          
          //echo "id: $id | price: $price | nombre: $nombre | idUser: $idUser";
          $objetoCarrito = CarritoObj::crea($id,$price,$nombre,$idUser);
          echo "HOLA HA LLEGADO AQUI";
        
        }
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





$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
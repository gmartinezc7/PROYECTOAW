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
        $price = $producto->getPrecio();
        $idUser = $producto->getIdUsuario();


        $codigohtml .= <<<EOS
        <p> Nombre: $nombre Descripcion: $descripcion Categoría: $tipo Fecha: $fecha Cantidad disponible: $stock | PRECIO: $price </p>       
        <form action="comprar.php" class="form-container" method="POST">
        <input type="hidden" name="prod" value='$prodsSerializado'>
        <input type="hidden" name="indice" value="$i">
        <input type='number' name='cantidad' min='1' max="$stock" value='1'>
        <div><button type="submit" name="botonComprar"> Comprar</button></div>
        </form>
    EOS;
     
        ++$i;

       
    }
    if (isset($_POST['botonComprar'])){
      $prod_sel = $busquedaProductos[$_POST['indice']];
      $id = $prod_sel->getId();
      $precio = $prod_sel->getPrecio();
      $nombre = $prod_sel->getNombreProd();
      $idUser = $prod_sel->getIdUsuario();
      $cantidad = $_POST['cantidad'];
      $objetoCarrito = CarritoObj::crea($id,$precio,$nombre,$idUser,$cantidad);
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
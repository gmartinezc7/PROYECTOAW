<?php
//require_once DIR.'/../../config.php';
//require_once DIR . '/comprar.php';

require_once __DIR__.'/includes/config.php';
use es\klaer\CarritoObj;
use es\klaer\usuarios\Usuario;
use es\klaer\Transaccion;

$tituloPagina = 'Carrito';
$contenidoPrincipal = '';


function buildFromCarrito(){
    $codigohtml='';
    $busquedaCarrito = CarritoObj::buscaDisponibles();
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
        <form action="carrito.php" class="form-container" method="POST">
        <input type="hidden" name="indice" value="$i">
        <div><button type="submit" name="eliminar"> Eliminar producto</button></div>
        </form>
        EOS;

        ++$i;
        $precioTotal += $aux;
    }
    

    if(isset($_POST['eliminar'])){
        $prod_eliminar = $busquedaCarrito[$_POST['indice']];
        $precioTotal -= $prod_eliminar->getCantidad()*$prod_eliminar->getPrecio();
        $exito = CarritoObj::borrate($prod_eliminar->getIdObj());
        if($exito){
            $codigohtml='';
            $busquedaCarrito = CarritoObj::buscaDisponibles();
            $i=0;
            foreach ($busquedaCarrito as $objcarrito){
                $idObj = $objcarrito->getIdObj();
                $precio = $objcarrito->getPrecio();
                $cantidad = $objcarrito->getCantidad();
                $nombreProd = $objcarrito->getNombreProd();
                $idUser = $objcarrito->getIdUser();
        
                $aux = $precio * $cantidad;
                $codigohtml .= <<<EOS
                <p> Nombre: $nombreProd Cantidad: $cantidad Precio: $aux </p>
                <form action="carrito.php" class="form-container" method="POST">
                <input type="hidden" name="indice" value="$i">
                <div><button type="submit" name="eliminar"> Eliminar producto</button></div>
                </form>
                EOS;
        
                ++$i;
            }
        } else {
            $codigohtml .= <<<EOS
            <p> Se ha producido un fallo en el proceso de borrado vuelvalo a intentar </p>
            EOS;
        }
    } else if (isset($_POST['confirmar'])){
        //  
        // Crear transaccion para cada producto

        $usuario = $_SESSION['nombre'];
        $idComprador = Usuario::buscaUsuario($usuario)->getId();

        foreach ($busquedaCarrito as $objcarrito){
            $idObj = $objcarrito->getIdObj();
            $precio = $objcarrito->getPrecio();
            $cantidad = $objcarrito->getCantidad();
            $nombreProd = $objcarrito->getNombreProd();
            $idVendedor = $objcarrito->getIdUser();
            $fecha = date('Y-m-d');

            //Esto crea la transacción por cada elemento del carrito
            $transaccion = Transaccion::crea($idComprador,$idVendedor,1,$idObj,$fecha,$cantidad);    
            
        }

        // Vaciar carrito
        CarritoObj::elimina();
        $codigohtml = <<<EOS
        <p> COMPRA REALIZADA CORRECTAMENTE </p>
        EOS;
        $precioTotal = 0;

    }

    

    
    if ($precioTotal > 0){
        $codigohtml .= <<<EOS
        <p> Precio total: $precioTotal </p>
        EOS;
         $codigohtml .= <<<EOS
        <form action="carrito.php" class="form-container" method="POST">
        <div><button type="submit" name="confirmar"> Confirmar compra</button></div>
        </form>
        EOS;
    }else{
        $codigohtml .= <<<EOS
        <p> El carrito está vacío.</p>
        EOS;

    }
   

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
//require DIR.'/../plantillas/lobby.php';
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);
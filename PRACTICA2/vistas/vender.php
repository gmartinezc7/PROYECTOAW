<?php
//require ("./comun/pie.php"); 
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

require_once '../Producto.php';

$tituloPagina = 'PáginaVentas';
$inicio = true;
$html = '';


$contenidoPrincipal = <<<EOS
<link rel="stylesheet" type="text/css" href='../css/estilo.css' />
<h1>VENDER</h1>

    <form action="vender.php" class="form-container" method="POST">

        <fieldset>
            <legend>Producto</legend>
            <div><label>Name:</label> <input type="text" name="productName"  /></div>
            <div><label>Price:</label> <input type="text" name="productPrice"  /></div>
            <div><label>Description:</label> <input type="text" name="productDescr"  /></div>
            <div><label>Type:</label> <input type="text" name="productType"  /></div>
            <div><label>Date:</label> <input type="date" name="productDate"  /></div>
            <div><label>Amount:</label> <input type="text" name="amount"  /></div>

            <div><button type="submit" name="boton">Entrar</button></div>
        </fieldset>

        <!--aqui faltaría poner la función que va a hacer que se muestren los productos con ese nombre/id/categoría-->

    </form>

EOS;

// Procesamiento del formulario 

if(isset($_POST['boton'])) {

    if(isset($_POST['productName'])){
        $nombre = $_POST['productName'];
    } else {
        $nombre = null;
    }

    if(isset($_POST['productPrice'])){
        $precio = $_POST['productPrice'];
    } else {
        $precio = null;
    }
     
    if(isset($_POST['productDescr'])){
        $descripcion = $_POST['productDescr'];
    } else {
        $descripcion = null;
    }

    if(isset($_POST['productType'])){
        $tipo = $_POST['productType'];
    } else {
        $tipo = null;
    }

    if(isset($_POST['productDate'])){
        $fecha = $_POST['productDate'];
    } else {
        $fecha = null;
    }
    
    if(isset($_POST['amount'])){
        $cantidad = $_POST['amount'];
    } else {
        $cantidad = null;
    }
    
    if($nombre == null or $fecha == null or $precio == null or $cantidad == null or $tipo == null or $descripcion == null){
        $html .= 'Complete todos los campos por favor';
    } else {
        $prod = Producto::crea($nombre, $precio, $descripcion, $tipo, $fecha, $cantidad);
       
        if($prod){
            $html .= '<p> Producto(s) registrado con exito con los siguientes campos: </p>';
            $html .= <<<EOS
            <p> Nombre: $nombre Precio: $precio Descripcion: $descripcion Tipo: $tipo Fecha: $fecha Cantidad disponible: $cantidad </p>
            EOS;

        } else {
            $html .= 'Se ha producido un error durante el registro del producto, intentelo de nuevo';
        }
    }
    
   $contenidoPrincipal .= $html;
}


require_once '../config.php';
require 'comun/lobby.php';

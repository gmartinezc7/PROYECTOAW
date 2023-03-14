

<?php
//require ("./comun/pie.php"); 
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'PáginaVentas';
$inicio = true;


$contenidoPrincipal = <<<EOS
<link rel="stylesheet" type="text/css" href='../css/estilo.css' />
<h1>VENDER</h1>

    <form action="../Aplicacion.php" class="form-container">

        <fieldset>
            <legend>Producto</legend>
            <div><label>Name:</label> <input type="text" name="productName"  /></div>
            <div><label>ID:</label> <input type="text" name="productId"  /></div>
            <div><label>Price:</label> <input type="text" name="productPrice"  /></div>
            <div><label>Description:</label> <input type="text" name="productDescr"  /></div>
            <div><label>Type:</label> <input type="text" name="productType"  /></div>
            <div><label>Date:</label> <input type="text" name="productDate"  /></div>
            <div><label>Amount:</label> <input type="text" name="password"  /></div>

            <div><button type="submit">Entrar</button></div>
        </fieldset>

        <!--aqui faltaría poner la función que va a hacer que se muestren los productos con ese nombre/id/categoría-->


    </form>


EOS;


function buildFormularioProductUpload()
{
    return <<<EOS
        <p>Prueba Formulario Product Upload </p>
    EOS;
}

//require_once 'includes/config.php';
require 'comun/lobby.php';

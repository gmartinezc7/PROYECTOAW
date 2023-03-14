

<?php
//require ("./comun/pie.php"); 
/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */

$tituloPagina = 'Página de Compras';
$inicio = true;


$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
	<h1>COMPRAR</h1>

    <div id="myForm">
        <form action="../Aplicacion.php" class="form-container">

            <label id="compra" for="busqueda"><b>Búsqueda</b></label>
            <textarea placeholder="Qué estás buscando?" name="Búsqueda" required></textarea>
            <br>

            <button id="submit" type="submit" class="btn">Send</button>

            <!--aqui faltaría poner la función que va a hacer que se muestren los productos con ese nombre/id/categoría-->


        </form>
    </div>
    

EOS;

require 'comun/lobby.php';

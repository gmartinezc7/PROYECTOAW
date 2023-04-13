<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" /></head>
		<title><?= $params['tituloPagina'] ?></title>
	</head>
	<body>
		
		<div id="contenedor">
		<?php
			$params['app']->doInclude('/vistas/comun/cabecera.php');
		?>
		<main>
			<article>
				<?= $mensajes ?>
				<?= $params['contenidoPrincipal'] ?>
			</article>
		</main>
				
		<?php
			$params['app']->doInclude('/vistas/comun/sidebarDer.php');
			$params['app']->doInclude('/vistas/comun/pie.php');
		?>
		</div>
	</body>
</html>

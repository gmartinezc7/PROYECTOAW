<?php
require_once __DIR__.'/includes/config.php';
use es\klaer\Publicacion;
use es\klaer\usuarios\Usuario;

$tituloPagina = 'Foro';

$contenidoPrincipal=<<<EOS
	<h1>Contenido del foro</h1>
EOS;

$result = es\klaer\Publicacion::cargarPub();
if(!$result)
	echo 'No se han podido cargar las publicaciones';
else if($result -> num_rows > 0){
	$contenidoPrincipal.=<<<EOS
	<table id="tablaForo">
	<tr>
		<th id="Foro"></th>
		<th>TITULO</th>
		<th>CREADOR</th>
		<th>RESPUESTAS</th>
		<th>FECHA</th>
	</tr>
	EOS;
	
    // Si hay, mostramos los temas
    while($row= $result->fetch_assoc()) { 
		$id = $row['id'];
		$title= $row['titulo'];
		$idUsuario = $row['idUsuario'];
		$respuestas = $row['respuestas'];
		$fecha= $row['fecha'];

		$nombreUsuario = Usuario::buscaPorId($idUsuario);
		$creador = $nombreUsuario->getUsuario();

		$contenidoPrincipal.=<<<EOS
			<tr>
				<td class="linksForo">
					<p><a href='verPublicacion.php?id=$id'>Ver</a></p>
				</td>
				<td>
					<p>$title</p>
				</td>
				<td>
					<p>$creador</p>
				</td>
				<td>
					<p>$respuestas</p>
				</td>
				<td>
					<p>$fecha</p>
				</td>
			</tr>
		EOS;
	  }

	$contenidoPrincipal.=<<<EOS
		</table>
	EOS;
}
else {
    $contenidoPrincipal.=<<<EOS
      <p>Todavia no hay publicaciones</p>
    EOS;
  }

$contenidoPrincipal.=<<<EOS
    <form action="crearPublicacion.php" method="POST">
    <p> Titulo: <input type="text" name="titulo_pub" /> </p>
    <p> Comentario: <input type="text" name="comentario" /> </p>
    <p><input type="submit" name="crearPublicacion" value="Publicar"/> </p>
    </form>
EOS;



  $result->free();     // Liberamos recursos

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);

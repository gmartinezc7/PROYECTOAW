<aside id="sidebarDer">
	<?php
		if ($inicio == true){
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido, {$_SESSION['nombre']} <a href='logout.php'>(salir)</a>";
				
			} else {
				echo "Usuario desconocido.";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='login.php'> LOGIN </a>
				&nbsp;&nbsp;
				<a href='registrarse.php'> REGISTRO </a>";
			}

			

		}else{
			echo "
			&nbsp;&nbsp;&nbsp;&nbsp;<a href='vistas/login.php'> LOGIN </a>
			&nbsp;&nbsp;<a href='vistas/registrarse.php'> REGISTRO </a>";

		}
		?>
</aside>

<aside id="sidebarDer">
	<?php
		if ($inicio == true){
			echo "
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='login.php'> LOGIN </a>
			&nbsp;&nbsp;
			<a href='registrarse.php'> REGISTRO </a>";

		}else{
			echo "
			&nbsp;&nbsp;&nbsp;&nbsp;<a href='vistas/login.php'> LOGIN </a>
			&nbsp;&nbsp;<a href='vistas/registrarse.php'> REGISTRO </a>";

		}
		?>
</aside>
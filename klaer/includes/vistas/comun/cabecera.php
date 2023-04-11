
<header>
    <?php
        use es\klaer\Aplicacion;

        $app=Aplicacion::getInstance();

            echo "<img src='".$app->resuelve('/img/logo.png')."' alt='Logo Klaer' width='130' height='130'>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/index.php')."'> Inicio </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/comprar.php')."'> Comprar </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/vender.php')."'> Vender </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/foro.php')."'> Foro </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/chat.php')."'> Chat </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/contacto.php')."'> Contacto </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href='".$app->resuelve('/carrito.php')."'> Carrito </a>";
			
			if ($app->tieneRol(es\klaer\usuarios\Usuario::ADMIN_ROLE)) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <a href='".$app->resuelve('/admin.php')."'> Administración </a>";
			}
        ?>



</header>
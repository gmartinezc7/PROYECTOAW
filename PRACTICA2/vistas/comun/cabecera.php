<header>
    <?php
        if(isset($contenidoPrincipal)== false){

            echo "<img src='../../logo.png' alt='Logo Klaer'>
            <a href='../pprincipal.php'> Inicio </a>
            <a href='../comprar.php'> Comprar </a>
            <a href='../vender.php'> Vender </a>
            <a href='../foro.php'> Foro </a>
            <a href='../chat.php'> Chat </a>
            <a href='../contacto.php'> Contacto </a>"; 
        }else{
            echo "<img src='../logo.png' alt='Logo Klaer'>
            <a href='pprincipal.php'> Inicio </a>
            <a href='comprar.php'> Comprar </a>
            <a href='vender.php'> Vender </a>
            <a href='foro.php'> Foro </a>
            <a href='chat.php'> Chat </a>
            <a href='contacto.php'> Contacto </a>";
        }
        ?>
	


</header>

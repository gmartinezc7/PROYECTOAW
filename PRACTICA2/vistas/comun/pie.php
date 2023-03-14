 <!-- añadir links e imagenes-->
<footer>
    <?php
        if (!isset($contenidoPrincipal)){
            echo "
            <a title='Twitter' href='https://twitter.com/home?lang=es'><img src='../../logotw.png' alt='Twitter' width='30' height='30' /></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a title='Facebook' href='https://www.facebook.com/'><img src='../../logofb.png' alt='Facebook' width='30' height='30' /></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a title='Instagram' href='https://www.instagram.com/?hl=es'><img src='../../logoig.png' alt='Instagram' width='30' height='30' /></a>";

        }else{
            echo "
            <a title='Twitter' href='https://twitter.com/home?lang=es'><img src='../logotw.png' alt='Twitter' width='30' height='30' /></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a title='Facebook' href='https://www.facebook.com/'><img src='../logofb.png' alt='Facebook' width='30' height='30' /></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a title='Instagram' href='https://www.instagram.com/?hl=es'><img src='../logoig.png' alt='Instagram' width='30' height='30' /></a>";
        }
    ?>
</footer>
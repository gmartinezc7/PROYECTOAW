<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" type="text/css" href="/Ejercicio2/estilo.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Procesar Login</title>
    </head>


<?php
// Empieza la sesión
session_start();

$username = htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));


if($username == "user" && $password == "userpass"){
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Usuario";
} elseif ($username == "admin" && $password == "adminpass"){
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = "Administrador";
    $_SESSION["esAdmin"] = true;

} 
?>

    <body>

        <div id="contenedor">

            <?php
                require ('cabecera.php');
                require ('sidebarIzq.php');
            ?>

            

            <main>
                <?php
                    if (!isset($_SESSION["login"])) { //Usuario incorrecto
                            echo "<h1>ERROR</h1>";
                            echo "<p>El usuario o contraseña no son válidos.</p>";
                        }
                        else { //Usuario registrado
                            echo "<h1>Bienvenido {$_SESSION['nombre']}</h1>";
                            echo "<p>Usa el menú de la izquierda para navegar.</p>";
                        }
                ?>
                
            </main>

            <?php
                require ('sidebarDer.php');
                require ('pie.php');
            ?>

        

        </div> <!-- Fin del contenedor -->

    </body>
</html>



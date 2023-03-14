<?php

function buildFormularioRegistro($username='', $password='', $email='',$tfl='',$dir='',$suscrib='') // Hay que procesar el registro creandolo en la base de datos, ademas comprobar si ya existe
{
    return <<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
    <form id="formLogin" action="procesarRegistro.php" method="POST">
        <fieldset>
            <legend>Nuevo usuario</legend>
            <div><label>Nombre de usuario:</label> <input type="text" name="username" value="$username" /></div>
            <div><label>Contraseña:</label> <input type="password" name="password" password="$password" /></div>
            <div><label>Email:</label> <input type="text" name="email" value="$email" /></div>
            <div><label>Telefono:</label> <input type="text" name="tfl" value="$tfl" /></div>
            <div><label>Dirección:</label> <input type="text" name="dir" value="$dir" /></div>
            <div><label>Suscribirse:</label> <input type="checkbox" name="suscrib" valuez="$suscrib" /></div>
            <div><button type="submit">Crear cuenta</button></div>
        </fieldset>
    </form>
    EOS;
}

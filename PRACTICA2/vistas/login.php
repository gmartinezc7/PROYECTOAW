<?php

function buildFormularioLogin($username='', $password='')
{
    return <<<EOS
    <link rel="stylesheet" type="text/css" href='../css/estilo.css' />
    <form id="formLogin" action="procesarLogin.php" method="POST">
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <div><label>Name:</label> <input type="text" name="username" value="$username" /></div>
            <div><label>Password:</label> <input type="password" name="password" password="$password" /></div>
            <div><button type="submit">Entrar</button></div>
        </fieldset>
    </form>
    EOS;
}
require ("./comun/pie.php"); 
<?php

/**require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php'; */
//require_once __DIR__.'/../../config.php';
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Chat';


$contenidoPrincipal=<<<EOS
    <link rel="stylesheet" type="text/css" href='../../../css/estilo.css' />
	<h1>Chat</h1>
    <button class="open-button" onclick="openForm()">Chat</button>

    <div class="chat-popup" id="myForm">
         <form action="/action_page.php" class="form-container">
            <h1>Chat</h1>

            <label for="msg"><b>Message</b></label>
            <textarea placeholder="Type message.." name="msg" required></textarea>

            <button type="submit" class="btn">Send</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
    

EOS;

//require __DIR__.'/../plantillas/lobby.php';
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/lobby.php', $params);


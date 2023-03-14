

<?php

$tituloPagina = 'PáginaPrincipal';


$contenidoPrincipal=<<<EOS
	<h1>PRINCIPAL</h1>
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

require 'comun/lobby.php';

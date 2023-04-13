<?php
namespace es\klaer\usuarios;

use es\klaer\Aplicacion;
use es\klaer\Formulario;

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $usuario =$datos['usuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['usuario', 'password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <div>
                <label for="usuario">Nombre de usuario:</label>
                <input id="usuario" type="text" name="usuario" value="$usuario" />
                {$erroresCampos['usuario']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="login">Entrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $usuario = trim($datos['usuario'] ?? '');
        $usuario = filter_var($usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $usuario || empty($usuario) ) {
            $this->errores['usuario'] = 'El nombre de usuario no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            $user = Usuario::login($usuario, $password);
        
            if (!$user) {
                $this->errores[] = "El usuario o el password no coinciden";
            } else {
                $app = Aplicacion::getInstance();
                $app->login($user);
            }
        }
    }
}

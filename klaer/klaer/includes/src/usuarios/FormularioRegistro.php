<?php
namespace es\klaer\usuarios;

use es\klaer\Aplicacion;
use es\klaer\Formulario;

class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $usuario = $datos['usuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';
		$apellidos = $datos['apellidos'] ?? '';
        $direccion = $datos['direccion'] ?? '';
		$telefono = $datos['telefono'] ?? '';
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
		$erroresCampos =self::generaErroresCampos(['usuario', 'nombre','password','password2','apellidos', 'email', 'telefono','direccion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
		$htmlErroresGlobales
		<fieldset>
		<legend>Datos para el registro</legend>
		<div class="grupo-control">
		<label for="usuario">Nombre de usuario:</label>
		<input class="control" type="text" name="usuario" value="$usuario" />{$erroresCampos['usuario']}
		</div>
		<div class="grupo-control">
		<label for="password">Password:</label> 
		<input class="control" type="password" name="password" />{$erroresCampos['password']}
		</div>
		<div class="grupo-control">
		<label for="password2">Reintroduce el password:</label> 
		<input class="control" type="password" name="password2" />{$erroresCampos['password2']}
		</div>
		<div class="grupo-control">
		<label for="nombre">Nombre:</label> 
		<input class="control" type="text" name="nombre" value="$nombre" />{$erroresCampos['nombre']}
		</div>
		<div class="grupo-control">
		<label for="apellidos">Apellidos:</label> 
		<input class="control" type="text" name="apellidos" value="$apellidos"/>{$erroresCampos['apellidos']}
		</div>
		<div class="grupo-control">
		<label for="email">Correo Electrónico:</label> 
		<input class="control" type="email" name="email" value="$email"/>{$erroresCampos['email']}
		</div>
		<div class="grupo-control">
		<label for="telefono">Teléfono:</label> 
		<input class="control" type="tell" name="telefono" value="$telefono"/>{$erroresCampos['telefono']}
		</div>
		<div class="grupo-control">
		<label for="direccion">Dirección:</label> 
		<input class="control" type="text" name="direccion" value="$direccion"/>{$erroresCampos['direccion']}
		</div>
		<div class="grupo-control">
		<button type="submit" name="registro">Registrar</button>
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
        if ( ! $usuario || mb_strlen($usuario) < 5) {
            $this->errores['usuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }

		$apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if ( empty($apellidos)) {
			$this->errores['apellidos'] = "Este campo es obligatorio.";
		}
		
		$direccion = trim($datos['direccion'] ?? '');
        $direccion = filter_var($direccion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if ( empty($direccion)) {
			$this->errores['direccion'] = "Este campo es obligatorio.";
		}
		
		
		$telefono = trim($datos['telefono'] ?? '');
        $telefono = filter_var($telefono, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if ( empty($telefono) || mb_strlen($telefono) < 9 ) {
			$this->errores['telefono'] = "El telefono no tiene el número de digitos correctos.";
		}
		
		$email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if ( empty($email)) {
			$this->errores['email'] = "Este campo es obligatorio.";
		}
		
        if (count($this->errores) === 0) {
            $user = Usuario::buscaUsuario($usuario);
            if ($user) {
                $this->errores[] = "El usuario ya existe";
            } else {
                $user = Usuario::crea($usuario, $password, $nombre, $apellidos, $direccion, $telefono ,$email, Usuario::USER_ROLE);
                $app = Aplicacion::getInstance();
                $app->login($user);
            }
        }
    }
}
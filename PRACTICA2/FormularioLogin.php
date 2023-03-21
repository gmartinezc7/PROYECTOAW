<?php
	require_once '../Aplicacion.php';
	require_once  '../Usuario.php';
	require_once  '../Formulario.php';

	
//Vemos que hereda de Form
	class FormularioLogin extends Formulario
	{
		public function __construct() {
			parent::__construct('formLogin');
		}
		
		protected function generaCamposFormulario($datos, $errores = array())
		{
			// Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
			$usuario =$datos['usuario'] ?? '';

			// Se generan los mensajes de error si existen.
			$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
			$errorusuario = self::createMensajeError($errores, 'usuario', 'span', array('class' => 'error'));
			$errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));

			// Se genera el HTML asociado a los campos del formulario y los mensajes de error.
			$html = <<<EOF
			<fieldset>
				<legend>Usuario y contraseña</legend>
				$htmlErroresGlobales
				<p><label>Nombre de usuario:</label> <input type="text" name="usuario" value="$usuario"/>$errorusuario</p>
				<p><label>Password:</label> <input type="password" name="password" />$errorPassword</p>
				<button type="submit" name="login">Entrar</button>
			</fieldset>
			EOF;
			return $html;
		}
		

		protected function procesaFormulario($datos)
		{
			$result = array();
			
			$usuario =$datos['usuario'] ?? null;
					
			if ( empty($usuario) ) {
				$result['usuario'] = "El nombre de usuario no puede estar vacío";
			}
			
			$password = $datos['password'] ?? null;
			if ( empty($password) ) {
				$result['password'] = "El password no puede estar vacío.";
			}
			
			//Vemos si un usuario ha iniciado sesión con éxito y establecemos las variables de sesión correspondientes. 
			//Si el inicio de sesión no es exitoso, se muestra un mensaje de error.
			if (count($result) === 0) {
				$usuario = Usuario::login($usuario, $password);
				if ( ! $usuario ) {
					// No se da pistas a un posible atacante
					$result[] = "El usuario o el password no coinciden";
				} else {
					//echo "ENTRAAAA";
					$_SESSION['login'] = true;
					//echo "ENTRAAAA";
					$_SESSION['nombre'] = $usuario;
					$_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 1 ? true : false;
					$result = 'pprincipal.php';
				}
			}
			return $result;
		}
	}
?>

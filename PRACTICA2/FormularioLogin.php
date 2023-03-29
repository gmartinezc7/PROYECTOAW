<?php
	require_once '../Aplicacion.php';
	require_once  '../Usuario.php';
	require_once  '../Formulario.php';

	
//Vemos que hereda de Form
	class FormularioLogin extends Formulario
	{
		public function __construct() {
			parent::__construct('formLogin', ['urlRedireccion' =>'pprincipal.php']);
		}
		
		protected function generaCamposFormulario(&$datos)
		{
			// Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
			$usuario =$datos['usuario'] ?? '';

			// Se generan los mensajes de error si existen.
			$htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
			$errorusuario = self::createMensajeError($this->errores, 'usuario', 'span', array('class' => 'error'));
			$errorPassword = self::createMensajeError($this->errores, 'password', 'span', array('class' => 'error'));
			$erroresCampos =self::generaErroresCampos(['usuario', 'password'], $this->errores, 'span', array('class' => 'error'));

			// Se genera el HTML asociado a los campos del formulario y los mensajes de error.
			$html = <<<EOF
			<fieldset>
				<legend>Usuario y contraseña</legend>
				$htmlErroresGlobales
				<p><label>Nombre de usuario:</label> <input type="text" name="usuario" value="$usuario"/></p> <p>{$erroresCampos['usuario']}</p>
				<p><label>Password:</label> <input type="password" name="password" /></p> <p>{$erroresCampos['password']}</p>
				<button type="submit" name="login">Entrar</button>
			</fieldset>
			EOF;
			return $html;
		}
		

		protected function procesaFormulario(&$datos)
		{
			$this->errores = [];
			
			$usuario =$datos['usuario'] ?? null;
					
			if ( empty($usuario) ) {
				$this->errores['usuario'] = "El nombre de usuario no puede estar vacío";
			}
			
			$password = $datos['password'] ?? null;
			if ( empty($password) ) {
				$this->errores['password'] = "El password no puede estar vacío.";
			}
			
			//Vemos si un usuario ha iniciado sesión con éxito y establecemos las variables de sesión correspondientes. 
			//Si el inicio de sesión no es exitoso, se muestra un mensaje de error.
			if (count($this->errores) === 0) {
				$usuario = Usuario::login($usuario, $password);
				if ( ! $usuario ) {
					// No se da pistas a un posible atacante
					$this->errores['usuario'] = "El usuario o el password no coinciden";
				} else {
					//echo "ENTRAAAA";
					$_SESSION['login'] = true;
					//echo "ENTRAAAA";
					$_SESSION['nombre'] = $usuario->getNombre();
					$_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 1 ? true : false;
				}
			}
		}
	}
?>

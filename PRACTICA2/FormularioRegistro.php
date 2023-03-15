<?php
	require_once '/Aplicacion.php';
	require_once  '/Usuario.php';
	require_once  '/Formulario.php';
	

	class FormularioRegistro extends Form
	{
		private const FORM_ID = 'form-registro';

		public function __construct(string $action)
		{
			parent::__construct(self::FORM_ID, array('action' => $action));
		}
		
		protected function generaCamposFormulario($datosIniciales, $errores = [])
		{
			$nombreUsuario = '';
			$app = Aplicacion::getInstance();

			if (!empty($datosIniciales))
			{
				$nombreUsuario = isset($datosIniciales['usuario']) ? $datosIniciales['usuario'] : $nombreUsuario;
			}

			$html = <<< HTML
				<fieldset>
					<legend>Usuario y contraseña</legend>
					<div class="grupo-control">
						<label>Nombre de usuario:</label> <input type="text" name="usuario"/>
					</div>
					<div class="grupo-control">
						<label>Nombre:</label> <input class="control" type="text" name="nombre"/>
					</div>
                    <div class="grupo-control">
						<label>Apellidos:</label> <input class="control" type="text" name="apellidos"/>
					</div>
                    <div class="grupo-control">
						<label>email:</label> <input class="control" type="email" name="email"/>
					</div>
                    <div class="grupo-control">
						<label>Teléfono:</label> <input class="control" type="tell" name="telefono"/>
					</div>
                    <div class="grupo-control">
						<label>Dirección:</label> <input class="control" type="text" name="direccion"/>
					</div>
                    <div class="grupo-control">
						<label>Contraseña:</label> <input type="password" name="password"/>
					</div>
					<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
				</fieldset>
			HTML;

			return $html;
		}
		
		protected function procesaFormulario($datos): void
		{
			$erroresFormulario = array();
			
			$nombreUsuario = isset($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : null;
			if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
				$erroresFormulario['nombreUsuario'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
			}
			
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
			if ( empty($nombre)) {
				$erroresFormulario['nombre'] = "Este campo es obligatorio.";
			}
			
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
			if ( empty($apellidos)) {
				$erroresFormulario['apellidos'] = "Este campo es obligatorio.";
			}

            $email = isset($_POST['email']) ? $_POST['email'] : null;
			if ( empty($email)) {
				$erroresFormulario['email'] = "Este campo es obligatorio.";
			}

            $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
			if ( empty($telefono) || mb_strlen($telefono) < 9 ) {
				$erroresFormulario['telefono'] = "El telefono no tiene el número de digitos correctos.";
			}

            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
			if ( empty($direccion) ) {
				$erroresFormulario['direccion'] = "Este campo es obligatorio.";
			}

			$password = isset($_POST['password']) ? $_POST['password'] : null;
			if ( empty($password) || mb_strlen($password) < 5 ) {
				$erroresFormulario['password'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
			}
			
			
			// Si no hay ningún error, continuar.
			if (empty($error))
			{
				$usuario = Usuario::crea($nombreUsuario, $nombre,$apellidos, $email, $password, 'user');

				if (! $usuario ) {
					$erroresFormulario[] = "El usuario ya existe";
					$this->generaListaErroresGlobales($erroresFormulario);
				} else {
					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $nombreUsuario;
					header('Location: index.php');
					exit();
				}
			}
			else
			{
				$this->generaListaErroresGlobales($erroresFormulario);
			}

			$this->generaFormulario();
		}
	}
?>
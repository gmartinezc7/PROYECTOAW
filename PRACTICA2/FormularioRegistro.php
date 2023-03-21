<?php
	require_once '../Aplicacion.php';
	require_once  '../Usuario.php';
	require_once  '../Formulario.php';
	

//Vemos que hereda de Form
class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $usuario = $datos['usuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';
		$apellidos = $datos['apellidos'] ?? '';
        $direccion = $datos['direccion'] ?? '';
		$telefono = $datos['telefono'] ?? '';
        $email = $datos['email'] ?? '';


        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorusuario = self::createMensajeError($errores, 'usuario', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
		$errorApellidos = self::createMensajeError($errores, 'apellidos', 'span', array('class' => 'error'));
		$errorEmail = self::createMensajeError($errores, 'email', 'span', array('class' => 'error'));
		$errorTelefono = self::createMensajeError($errores, 'telefono', 'span', array('class' => 'error'));
		$errorDireccion = self::createMensajeError($errores, 'direccion', 'span', array('class' => 'error'));

        $html = <<<EOF
			<fieldset>
				$htmlErroresGlobales
				<div class="grupo-control">
				<label>Nombre de usuario:</label> <input class="control" type="text" name="usuario" value="$usuario" />$errorusuario
				</div>
				<div class="grupo-control">
				<label>Password:</label> <input class="control" type="password" name="password" />$errorPassword
				</div>
				<div class="grupo-control">
				<label>Nombre completo:</label> <input class="control" type="text" name="nombre" value="$nombre" />$errorNombre
				</div>
				<div class="grupo-control">
				<label>Apellidos:</label> <input class="control" type="text" name="apellidos" value="$apellidos"/>$errorApellidos
				</div>
				<div class="grupo-control">
				<label>email:</label> <input class="control" type="email" name="email" value="$email"/>$errorEmail
				</div>
				<div class="grupo-control">
				<label>Teléfono:</label> <input class="control" type="tell" name="telefono" value="$telefono"/>$errorTelefono
				</div>
				<div class="grupo-control">
				<label>Dirección:</label> <input class="control" type="text" name="direccion" value="$direccion"/>$errorDireccion
				</div>
				<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
			</fieldset>
		EOF;
		return $html;
	}
    

    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $usuario = $datos['usuario'] ?? null;
        
        //Si el nombre de usuario es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($usuario) || mb_strlen($usuario) < 5 ) {
            $result['usuario'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $nombre = $datos['nombre'] ?? null;
        //Si el nombre es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $result['nombre'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = $datos['password'] ?? null;
        //Si la contraseña es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result['password'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }

		$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
		if ( empty($apellidos)) {
			$erroresFormulario['apellidos'] = "Este campo es obligatorio.";
		}

		$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
		if ( empty($direccion) ) {
			$erroresFormulario['direccion'] = "Este campo es obligatorio.";
		}

		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		if ( empty($telefono) || mb_strlen($telefono) < 9 ) {
			$erroresFormulario['telefono'] = "El telefono no tiene el número de digitos correctos.";
		}

		$email = isset($_POST['email']) ? $_POST['email'] : null;
		if ( empty($email)) {
			$erroresFormulario['email'] = "Este campo es obligatorio.";
		}

        //Vemos si un usuario se ha creado con éxito. 
        //Si el usuario ya existe, te muestra un mensaje
        if (count($result) === 0) {
            $user = Usuario::crea($usuario, $password, $nombre, $apellidos, $direccion, $telefono ,$email, 'user');

            if ( !$user ) {
                $result[] = "El usuario ya existe";
            } else {
			$_SESSION['login'] = true;
			$_SESSION['nombre'] = $usuario;
			$result = 'pprincipal.php';
            }
        }
        return $result;
    }
}
?>

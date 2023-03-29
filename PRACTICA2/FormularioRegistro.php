<?php
	require_once '../Aplicacion.php';
	require_once  '../Usuario.php';
	require_once  '../Formulario.php';
	

//Vemos que hereda de Form
class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' =>'pprincipal.php']);
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
        $errorusuario = self::createMensajeError($this->errores, 'usuario', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($this->errores, 'nombre', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($this->errores, 'password', 'span', array('class' => 'error'));
		$errorApellidos = self::createMensajeError($this->errores, 'apellidos', 'span', array('class' => 'error'));
		$errorEmail = self::createMensajeError($this->errores, 'email', 'span', array('class' => 'error'));
		$errorTelefono = self::createMensajeError($this->errores, 'telefono', 'span', array('class' => 'error'));
		$errorDireccion = self::createMensajeError($this->errores, 'direccion', 'span', array('class' => 'error'));
		$erroresCampos =self::generaErroresCampos(['usuario', 'nombre','password','apellidos', 'email', 'telefono','direccion'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
			<fieldset>
				$htmlErroresGlobales
				<div class="grupo-control">
				<label>Nombre de usuario:</label> <input class="control" type="text" name="usuario" value="$usuario" />{$erroresCampos['usuario']}
				</div>
				<div class="grupo-control">
				<label>Password:</label> <input class="control" type="password" name="password" />{$erroresCampos['password']}
				</div>
				<div class="grupo-control">
				<label>Nombre completo:</label> <input class="control" type="text" name="nombre" value="$nombre" />{$erroresCampos['nombre']}
				</div>
				<div class="grupo-control">
				<label>Apellidos:</label> <input class="control" type="text" name="apellidos" value="$apellidos"/>{$erroresCampos['apellidos']}
				</div>
				<div class="grupo-control">
				<label>email:</label> <input class="control" type="email" name="email" value="$email"/>{$erroresCampos['email']}
				</div>
				<div class="grupo-control">
				<label>Teléfono:</label> <input class="control" type="tell" name="telefono" value="$telefono"/>{$erroresCampos['telefono']}
				</div>
				<div class="grupo-control">
				<label>Dirección:</label> <input class="control" type="text" name="direccion" value="$direccion"/>{$erroresCampos['direccion']}
				</div>
				<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
			</fieldset>
		EOF;
		return $html;
	}
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $usuario = $datos['usuario'] ?? null;
        
        //Si el nombre de usuario es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($usuario) || mb_strlen($usuario) < 5 ) {
			$this->errores['usuario'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $nombre = $datos['nombre'] ?? null;
        //Si el nombre es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
        	$this->errores['nombre'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = $datos['password'] ?? null;
        //Si la contraseña es vacio o con menos de 5 caracteres muestra un mensaje de error
        if ( empty($password) || mb_strlen($password) < 5 ) {
        	$this->errores['password'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }

		$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
		if ( empty($apellidos)) {
			$this->errores['apellidos'] = "Este campo es obligatorio.";
		}

		$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
		if ( empty($direccion) ) {
			$this->errores['direccion'] = "Este campo es obligatorio.";
		}

		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		if ( empty($telefono) || mb_strlen($telefono) < 9 ) {
			$this->errores['telefono'] = "El telefono no tiene el número de digitos correctos.";
		}

		$email = isset($_POST['email']) ? $_POST['email'] : null;
		if ( empty($email)) {
			$this->errores['email'] = "Este campo es obligatorio.";
		}

        //Vemos si un usuario se ha creado con éxito. 
        //Si el usuario ya existe, te muestra un mensaje
        if (count($this->errores) === 0) {
            $user = Usuario::crea($usuario, $password, $nombre, $apellidos, $direccion, $telefono ,$email, 'user');

            if ( !$user ) {
            	$this->errores['usuario'] = "El usuario ya existe";
            } else {
			$_SESSION['login'] = true;
			$_SESSION['nombre'] = $usuario->getNombre();
            }
        }
    }
}
?>

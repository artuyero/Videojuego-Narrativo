<?php
require_once '../User.php';
require_once 'Form.php';

class FormLogin extends Form {
    public function __construct() {
        parent::__construct('Login', array('action' => 'Login.php'));
    }

    protected function generaCamposFormulario($datos) {
        $html = '<div>
                    <div>
                        <input type="text" name="username" id="username" value="" placeholder="Username" />
                    </div> <br>
                    <div>
                        <input type="password" name="pass" id="pass" value="" placeholder="Contraseña" />
                    </div> <br>
                     <div>
                        <input type="submit" value="Aceptar" />
                    </div>
                </div>
                ';
        return $html;
    }

    protected function procesaFormulario($datos) {   

        $erroresFormulario = array();

        $username = isset($datos['username']) ? $datos['username'] : null;

        if ( empty($username) ) {
            $erroresFormulario[] = "El username no puede estar vacío";
        }

        $password = isset($datos['pass']) ? $datos['pass'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) == 0) {
            if ($usuario = User::login($username, $password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['username'] = $usuario->getUsername();
                    return "../index.php";
            } else
                $erroresFormulario[] = "No existe usuario con ese nombre o la contraseña es incorrecta";
        }
        return $erroresFormulario;
    }
}   
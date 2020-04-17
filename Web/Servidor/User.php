<?php
require_once __DIR__ . '/Aplication.php';
require_once __DIR__ . '/DB_data.php';


class User
{
    private $id;
    private $username;
    private $pass;

    private function __construct($array)
    {
        $this->username= $array[0];
        $this->pass = $array[1];
    }


    public static function login($username, $password)
    {
        $user = self::find_user_by_username($username);

        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }


    public static function find_user_by_username($username)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $datos = array($fila['username'],$fila['password']);
                $user = new User($datos);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        return $result;
    }


    public static function find_by_id($id)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM Users U WHERE U.id = '%d'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $datos = array($fila['username'],$fila['password']);
                $user = new User($datos);
                $user->id = $fila['id'];
                $result = $user;  
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    public static function insert_user($username, $email, $pass)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO Users (username, email, password) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($username),
            $conn->real_escape_string($email),
            self::hashPassword($pass)
            );
        if ( $conn->query($query) ) {
            $fila = array($username, $pass);
            $user = new User($fila);
            $user->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
            exit();
        }
        return $user;
    }
    
    // Funciona
    public function borrar_usuario($username){

        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_user = $fila["id"];

        $query = sprintf("DELETE FROM Statistics WHERE id_user = '%d'",
            $conn->real_escape_string($id_user)
            );
        if (! $conn->query($query) ) {
            $user->id = $conn->insert_id;
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        $query = sprintf("DELETE FROM Messages WHERE (id_sender = '%d' or id_receiver = '%d')",
            $conn->real_escape_string($id_user),
            $conn->real_escape_string($id_user)
            );
        if (! $conn->query($query) ) {
            $user->id = $conn->insert_id;
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        $query = sprintf("DELETE FROM State_Game WHERE id_user = '%d'",
            $conn->real_escape_string($id_user)
            );
        if (! $conn->query($query) ) {
            $user->id = $conn->insert_id;
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        $query = sprintf("DELETE FROM Games WHERE (user = '%d')",
        $conn->real_escape_string($id_user),
        $conn->real_escape_string($id_user)
            );
        if (! $conn->query($query) ) {
            $user->id = $conn->insert_id;
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }


        $query = sprintf("DELETE FROM Users WHERE id = '%d'",
            $conn->real_escape_string($id_user)
            );
        if (! $conn->query($query) ) {
            $user->id = $conn->insert_id;
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return 1;
    }


    public function guardar_estadisticas($username, $timed){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

		$query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_user = $fila["id"];

		$query = sprintf("SELECT id, date_start FROM Games G WHERE user = '%d'", $id_user);
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_game = $fila["id"];
        $date_start = $fila["date_start"];

        $query = sprintf("INSERT INTO Statistics (id_user, id_game, timed, date_start) VALUES ('%d', '%d', '%f', '%s')",
            $id_user,
            $id_game,
            $timed,
            $date_start
            );

        if (! $conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
            exit();
        }
        return true;
    }

    public function cargar_estadisticas($username){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_user = $fila["id"];

        $query = sprintf("SELECT * FROM Statistics S join Games G on (S.id_game = G.id) WHERE (S.id_user = '%d')", $id_user);

        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $result[] = $fila;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    public function cargar_objetos($id_user){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT O.real_name, O.description FROM State_game S join Objects O on (S.object = O.name) WHERE (S.id_user = '%d')", $id_user);

        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $result[] = $fila;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    /* Utils ---------------------------------------------------------------------------------*/

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


    public function compruebaPassword($password)
    {
        return password_verify($password, $this->pass);
    }


    /* Getters and Setters -------------------------------------------------------------------*/

    public function getId()
    {
        echo ("Hola");
        return $this->id;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function getPass()
    {
        return $this->pass;
    }
}
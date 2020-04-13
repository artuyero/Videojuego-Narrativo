<?php
require_once __DIR__ . '/Aplication.php';


class Game
{   
    private $id;
    private $user;
    private $date_start;


    private function __construct($array)
    {
        $this->user= $array['user'];
        $this->date_start = $array['date_start'];
    }


    // Funciona
    public function inicia_nuevo_juego_individual($user)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($user));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_usuario = $fila["id"];

        if ( ! $id_usuario) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }

        # Recuperamos el id de la partida individual que tiene user activa si la tiene
        $query = sprintf("SELECT id FROM Games G WHERE user = '%d'", $id_usuario);
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_game = $fila["id"];

        # Si tenia una partida, borramos de la tabla de estado de la misma
        if($id_game){
                $query = sprintf("DELETE FROM State_Game WHERE id_game = '%d'",
                    $conn->real_escape_string($id_game)
                );
                $rs = $conn->query($query);
                if ( ! $rs) {
                    echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                    return false;
                }

                # Y ademas borramos la partida propiamente de la tabla Games
                $query = sprintf("DELETE FROM Games WHERE user = '%d'",
                $id_usuario
                );
                $rs = $conn->query($query);
                if ( ! $rs ) {
                    echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                    return false;
                } 
        }

        # Insertamos una nueva partida individual
        $query = sprintf("INSERT INTO Games (user) VALUES ('%d')",
            $id_usuario
            );

        if ( $conn->query($query) ) {
            $id_new_game = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }
        return true;
    }



    // Funciona
    public function cargar_partida_individual($username) {

        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_usuario = $fila["id"];

        # Recuperamos el id de la partida individual
        $query = sprintf("SELECT object, type, state_object FROM  State_Game S where S.id_user = '%d'", $id_usuario);
        $rs = $conn->query($query);

        // Esto nos devuelve todos los objetos del usuario en su partida individual y su estado
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $aux = $fila["type"].":".$fila["state_object"];
                $result[$fila["object"]] = $aux;
            }

            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }
        return $result;
    }

    // Funciona
    public function guardar_partida_individual($datos) {
        
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $usuario = $datos["username"];

        $query = sprintf("SELECT id FROM Users U WHERE U.username = '%s'", $conn->real_escape_string($usuario));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_usuario = $fila["id"];

        if ( ! $id_usuario) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }

        $query = sprintf("SELECT id FROM Games G WHERE G.user = '%d'", $id_usuario);
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        $id_game = $fila["id"];

        if ( ! $id_game) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }

        $query = sprintf("DELETE FROM State_Game WHERE id_user = '%d'", $id_usuario);
        $rs = $conn->query($query);
        if ( ! $rs) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }

        $fila = array();

        foreach($datos as $clave=>$valor) {
            if($clave == "username"){
                $username = $valor;
            }
            else{
                $fila = str_split($valor);
                $objeto = $clave;
                $tipo = intval($fila[0]);
                $estado = intval($fila[2]);

                $query = sprintf("INSERT INTO State_Game (id_game, id_user, object, type, state_object) VALUES ('%d', '%d', '%s', '%d', '%d')",
                $id_game,
                $id_usuario,
                $conn->real_escape_string($objeto),
                $tipo,
                $estado
                );

                if (! $conn->query($query) ) {
                    echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                    return false;
                }
            }
        }

        return true;
    }


    /* Getters and Setters -------------------------------------------------------------------*/

    public function getId()
    {
        return $this->id;
    }


    public function getUser()
    {
        return $this->user;
    }

    public function getDate()
    {
        return $this->date_start;
    }
}
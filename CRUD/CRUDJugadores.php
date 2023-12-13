<?php
require_once("Connection.php");

class Jugador
{
    public function showAllJugadores()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM jugadores JOIN liga ON jugadores.liga=liga.id_liga";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }

    public function getJugadoresByName($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM jugadores WHERE jugadores.nombre = '$data'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function getJugadorByID($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM jugadores WHERE jugadores.id = '$data[0]'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function createJugador($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("INSERT INTO jugadores (id, nombre, liga, img) VALUES (NULL, ?, ?, ? )");
        $stmt->bind_param("sis", $data[0], $data[1], $data[2]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede insertar el jugador");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function deleteJugador($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("DELETE FROM jugadores WHERE jugadores.id = ?");
        $stmt->bind_param("i", $data[0]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede borrar el jugador");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function updateJugador($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("UPDATE jugadores SET nombre = ?, liga = ?, img = ? WHERE jugadores.id = ?");
        $stmt->bind_param("sisi", $data[1], $data[2], $data[3], $data[0]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede actualizar el jugador");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }
}

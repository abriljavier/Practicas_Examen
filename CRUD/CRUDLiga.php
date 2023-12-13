<?php
require_once("Connection.php");

class Liga
{
    public function showAllLigas()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM liga";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }
    public function getLigaByName($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM liga WHERE liga.nombre_liga = '$data'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function getLigaByID($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM liga WHERE liga.id_liga = '$data[0]'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function createLiga($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("INSERT INTO liga (id_liga, nombre_liga, imagen_liga) VALUES (NULL, ?, ?)");
        $stmt->bind_param("ss", $data[0], $data[1]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede insertar la liga");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function deleteLiga($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("DELETE FROM liga WHERE liga.id_liga = ?");
        $stmt->bind_param("i", $data[0]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede borrar el usuario");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function updateLiga($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("UPDATE liga SET nombre_liga = ?, imagen_liga = ? WHERE liga.id_liga = ?");
        $stmt->bind_param("ssi", $data[1], $data[2], $data[0]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede actualizar el usuario");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }
}

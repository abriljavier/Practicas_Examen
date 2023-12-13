<?php
require_once("Connection.php");

class User
{
    public function showAllUsers()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuarios JOIN roles ON usuarios.rol=roles.id";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }

    public function getUserByName($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuarios WHERE usuarios.usuario = '$data'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function getUserByID($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuarios WHERE usuarios.id = '$data[0]'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function createUser($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("INSERT INTO usuarios (id, usuario, password, rol) VALUES (NULL, ?, ?, ? )");
        $stmt->bind_param("sss", $data[0], $data[1], $data[2]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede insertar el usuario");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function deleteUser($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("DELETE FROM usuarios WHERE usuarios.id = ?");
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

    public function updateUser($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("UPDATE usuarios SET usuario = ?, password = ?, rol = ? WHERE usuarios.id = ?");
        $stmt->bind_param("ssii", $data[1], $data[2], $data[3], $data[0]);
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

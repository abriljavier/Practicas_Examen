<?php
require_once("Connection.php");

class Rol
{
    public function showAllRoles()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM roles";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }
    public function getRolByName($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM roles WHERE roles.rol = '$data'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function getRolByID($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM roles WHERE roles.id = '$data[0]'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }
    public function createRol($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("INSERT INTO roles (id, rol) VALUES (NULL, ?)");
        $stmt->bind_param("s", $data[0]);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            die("No se puede insertar el usuario");
        }
        $stmt->close();
        $sqlConnection->closeConnection($mySQL);
        return true;
    }

    public function deleteRol($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("DELETE FROM roles WHERE roles.id = ?");
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

    public function updateRol($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $stmt = $mySQL->prepare("UPDATE roles SET rol = ? WHERE roles.id = ?");
        $stmt->bind_param("si", $data[1], $data[0]);
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

<?php
require_once("Connection.php");

class Usuarios
{
    public function showUsuarios()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuario JOIN roles ON usuario.rol = roles.id;";
        //El select tiene return y se necesita igualar, en este caso
        //$result
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_all(MYSQLI_BOTH);
    }

    public function showOneUsuario($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuario WHERE usuario.id_usuario = $data";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function getUserByName($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "SELECT * FROM usuario WHERE usuario.usuario = '$data'";
        $result = $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function addUsuarios($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "INSERT INTO usuario (id_usuario, usuario, password, rol) VALUES (NULL, '$data[0]', '$data[1]', '$data[2]')";
        $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
    }

    public function editUsuarios($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "UPDATE usuario SET usuario = '$data[1]', password = '$data[2]', rol = '$data[3]' WHERE usuario.id_usuario = $data[0]";
        $mySQL->query($sql) or die($mySQL->error);
        $sqlConnection->closeConnection($mySQL);
    }

    public function deleteUsuarios($data)
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection();
        $sql = "DELETE FROM usuario WHERE usuario.id_usuario = $data";
        $mySQL->query($sql);
        $sqlConnection->closeConnection($mySQL);
    }
}

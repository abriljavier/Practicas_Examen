<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
class Connection
{
    private $server = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "dnd";

    public function getConnection() // Corrección del nombre del método
    {
        return $conexion = new mysqli(
            $this->server,
            $this->user,
            $this->password,
            $this->db
        );
    }

    public function closeConnection($conexion)
    {
        $conexion->close();
    }
}

$conexion = new Connection();

$connection = $conexion->getConnection();

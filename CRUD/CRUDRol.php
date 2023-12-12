<?php
require_once("Connection.php");

class Rol
{
    public function showRoles()
    {
        $sqlConnection = new Connection();
        $mySQL = $sqlConnection->getConnection("");
        $sql = "SELECT * FROM rol";
        $result = $mySQL->query($sql);
        //COMPROBAR EL ÉXITO DE LAS QUERYS
        if ($mySQL->errno > 0) {
            $result = false;
        } else {
            return $result->fetch_all(MYSQLI_BOTH);
        }

        $sqlConnection->closeConnection($mySQL);
        return $result;
    }
}

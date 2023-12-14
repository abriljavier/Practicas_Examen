<?php

//Todos los include
require("./CRUD/CRUDUser.php");
require("./CRUD/CRUDRoles.php");
require("./CRUD/CRUDLiga.php");
require("./CRUD/CRUDJugadores.php");
include("./img/resize-class.php");
include("./sessions/inactividad.php");
include("./sessions/checksession.php");
include("./templates/header.php");
$dataUsuarios = new User();
$dataRoles = new Rol();
$dataLigas = new Liga();
$dataJugadores = new Jugador();

//LA VARIABLE QUE CONTROLA EL ACCESO
$baddAccess = false;

//Login de acceso del usuario
if (isset($_POST['login'])) {
    $name = $_POST['user'];
    $pass = md5($_POST['password']);
    if ($bbddUserData = $dataUsuarios->getUserByName($name)) {
        if ($bbddUserData && $pass == $bbddUserData['password']) {
            // echo $bbddUserData['id'] . "</br>";
            // echo $bbddUserData['usuario'] . "</br>";
            // echo $bbddUserData['password'] . "</br>";
            // echo $bbddUserData['rol'] . "</br>";
            switch ($bbddUserData['rol']) {
                case 1:
                    session_start();
                    $_SESSION['user'] = $bbddUserData['usuario'];
                    setcookie("user", $bbddUserData['usuario'], time() + 600);
                    setcookie("rol", $bbddUserData['rol'], time() + 6000);
                    header('Location: ./private.php');
                    break;
                case 2:
                    session_start();
                    $_SESSION['user'] = $bbddUserData['usuario'];
                    setcookie("admin", $bbddUserData['usuario'], time() + 600);
                    setcookie("rol", $bbddUserData['rol'], time() + 6000);
                    header('Location: ./private.php');
                    break;
            }
        } else {
            $baddAccess = true;
        }
    }
}
//UNA VEZ CARGADA LA SESIÓN
if (isset($_SESSION['user'])) {
    $usuarioActual = $_SESSION['user'];
    $rolUsuario = $_COOKIE["rol"];
}



if ($baddAccess) {
    ?>
    <div>
        Acceso denegado
    </div>
    <?php
} else if (isset($usuarioActual)) {
    ?>
        <p class="saludo">Bienvenido
        <?php echo $usuarioActual ?>
        </p>
        <div class="contentSelector">
            <a href="./private.php?showJugadores">Tabla jugadores</a>
            <a href="./private.php?showLigas">Tabla ligas</a>
        <?php if ($usuarioActual == 'admin') { ?>
                <a href="./private.php?showUsuarios">Tabla usuarios</a>
                <a href="./private.php?showRoles">Tabla roles</a>
        <?php } ?>
        </div>
        <div class="mainContent">
        <?php if (isset($_GET['showUsuarios'])) {
            include("./tables/Usuarios.php");
        } else if (isset($_GET['showRoles'])) {
            include("./tables/Roles.php");
        } else if (isset($_GET['showLigas'])) {
            include("./tables/Liga.php");
        } else if (isset($_GET['showJugadores'])) {
            include("./tables/Jugadores.php");
        } ?>
        </div>
    <?php
}

include("./templates/footer.php");

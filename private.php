<?php

//Todos los include
include("./templates/header.php");
require("./CRUD/CRUDUser.php");
$dataUsuarios = new User();

//LA VARIABLE QUE CONTROLA EL ACCESO
$baddAccess = false;
$typeAccess = 0;

//Login de acceso del usuario
if (isset($_POST['login'])) {
    $name = $_POST['user'];
    $pass = $_POST['password'];
    $bbddUserData = $dataUsuarios->getUserByName($name);
    if ($bbddUserData && $pass == $bbddUserData['password']) {
        switch ($bbddUserData) {
            case 1:
                $typeAccess = 1;
                session_start();
                $_SESSION['user'] = $bbddUserData['nombre'];
                setcookie("user", $userData['usuario'], time() + 600);
                setcookie("rol", $userData['rol'], time() + 6000);
                header('Location: ./private.php');
                break;
            case 2:
                $typeAccess = 2;
                break;
        }
    } else {
        $baddAccess = true;
    }
}


if ($baddAccess) {
?><p>
        Acceso denegado
    </p>
<?php
} else {
?>
    <p>Bienenido <?php echo $name ?></p>
<?php
}

include("./templates/footer.php");

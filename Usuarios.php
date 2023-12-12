<?php

//EVITAR ACCESO POR URL SIN SESIÓN
if (!isset($_SESSION)) {
    header("Location: ../../index.php?noSession");
}

//CARGAR LAS BBDD
require_once(__DIR__ . '/CRUD/CRUDUsuarios.php');
$dataBase = new Usuarios();
require_once(__DIR__ . '/CRUD/CRUDRoles.php');
$dataRoles = new Roles();

//MOSTRAR USUARIOS Y ROLES
$usuarios = $dataBase->showUsuarios();
$roles = $dataRoles->showRoles();

if (isset($_POST["enviarUsuarios"])) {
    $idSiEditar = $_POST["idSiEditar"];
    //CREAR USUARIOS
    if (!$idSiEditar) {
        $name = $_POST["name"];
        $password = md5($_POST["password"]);
        $rol = $_POST["rol"];
        $data = [$name, $password, $rol];
        $dataBase->addUsuarios($data);
        if (!headers_sent()) {
            header("Location:./private.php?ver=usuarios");
        } else {
            echo "<script type='text/javascript'>";
            echo "window.location.href='./private.php?ver=usuarios'";
            echo "</script>";
            exit;
        }
    } else {
        //EDITAR USUARIO
        $id = $idSiEditar;
        $name = $_POST["name"];
        $password = $_POST["password"];
        $rol = $_POST["rol"];
        $data = [$id, $name, $password, $rol];
        $dataBase->editUsuarios($data);
        if (!headers_sent()) {
            header("Location:./private.php?ver=usuarios");
        } else {
            echo "<script type='text/javascript'>";
            echo "window.location.href='./private.php?ver=usuarios'";
            echo "</script>";
            exit;
        }
    }
}

//ELIMINAR USUARIOS
if (isset($_GET["borrarUsuarios"])) {
    $id = $_GET["id"];
    echo $id;
    $dataBase->deleteUsuarios($id);
    if (!headers_sent()) {
        header("Location:./private.php?ver=usuarios");
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location.href='./private.php?ver=usuarios'";
        echo "</script>";
        exit;
    }
}

//EDITAR USUARIOS
if (isset($_GET['editarUsuarios'])) {
    $id = $_GET['id'];
    if (!isset($_GET['cargarDatosEnviar'])) {
        $datosUsuario = $dataBase->showOneUsuario($id);
        $name = $datosUsuario["usuario"];
        $pass = $datosUsuario["password"];
        $rol = $datosUsuario["rol"];
        $idParaEditar = $id;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .tabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabla,
        .tabla th,
        .tabla td {
            border: 1px solid black;
        }

        .tabla th,
        .tabla td {
            padding: 10px;
            text-align: left;
        }

        .tabla th {
            background-color: #f2f2f2;
        }

        .tabla tr.datos:hover {
            background-color: #f5f5f5;
        }

        .datos td {
            /* Aplica a todas las filas excepto la primera */
            padding: 10px;
            text-align: left;
        }

        .first {
            /* Aplica solo a la primera fila */
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .accion {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            cursor: pointer;
        }

        .accion:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function confirmBorrar(id, name) {
            if (confirm("Seguro que deseas borrar " + name)) {
                console.log("Hola");
                location.href = "private.php?ver=usuarios&borrarUsuarios&id=" + id;
            }
        }
    </script>
</head>

<body>
    <table class="tabla">
        <tr class="first">
            <td>ID</td>
            <td>Nombre</td>
            <td>Password</td>
            <td>Rol</td>
            <td></td>
            <td></td>
        </tr>

        <?php
        //MOSTRAR LA TABLA
        foreach ($usuarios as $user) {
            ?>
            <tr class="datos">
                <td>
                    <?php echo $user[0] ?>
                </td>
                <td>
                    <?php echo $user[1] ?>
                </td>
                <td>
                    <?php echo md5($user[2]) ?>
                </td>
                <td>
                    <?php echo $user[5] ?>
                </td>
                <td class="accion">
                    <a href="private.php?ver=usuarios&id=<?php echo $user[0] ?>&editarUsuarios">Editar</a>
                </td>
                <td class="accion">
                    <a href="#" onclick="confirmBorrar('<?php echo $user[0] ?>','<?php echo $user[1] ?>')">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <!-- EL FORMULARIO PARA CREAR USUARIOS -->
    <h3>El FORMULARIO PARA AÑADIR CAMPOS</h3>
    <form action="private.php?ver=usuarios" method="post">
        <p>Por favor inserta tu nombre</p>
        <input type="text" name="name" id="" value="<?php echo isset($name) ? $name : ''; ?>" required>
        <p>Por favor ingresa tu contraseña</p>
        <input type="text" name="password" id="" value="<?php echo isset($pass) ? $pass : ''; ?>" required>
        <p>Por favor ingresa el rol</p>
        <select name="rol" id="">
            <?php

            foreach ($roles as $oneRol) {
                ?>
                <option value="<?php echo $oneRol["id"] ?>" <?php if (isset($rol) && $rol == $oneRol["id"]) { ?> selected
                    <?php } ?>>
                    <?php echo $oneRol["nombre"] ?>
                </option>
                <?php
            }
            ?>
        </select>
        <p></p>
        <!-- HIDDEN PARA MANDAR DOS VECES EL EDITAR -->
        <input type="hidden" name="idSiEditar" value="<?php echo $idParaEditar ?? null ?>" required>
        <input type="submit" value="<?php echo isset($name) ? 'Editar usuario' : 'Enviar'; ?>" name="enviarUsuarios">
    </form>

</body>

</html>
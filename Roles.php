<?php
if (!isset($_SESSION)) {
    header("Location: ../../index.php?noSession");
}
require_once(__DIR__ . '/CRUD/CRUDRoles.php');
$dataBase = new Roles();

//MOSTRAR ROLES
$roles = $dataBase->showRoles();

if (isset($_POST["enviarRoles"])) {
    $idSiEditar = $_POST["idSiEditar"];
    //CREAR ROLES
    if (!$idSiEditar) {
        $name = $_POST["name"];
        $data = [$name];
        $dataBase->addRol($data);
        if (!headers_sent()) {
            header("Location:./private.php?ver=roles");
        } else {
            echo "<script type='text/javascript'>";
            echo "window.location.href='./private.php?ver=roles'";
            echo "</script>";
            exit;
        }
    } else {
        //EDITAR ROLES
        $id = $idSiEditar;
        $name = $_POST["name"];
        $data = [$id, $name];
        $dataBase->editRol($data);
        if (!headers_sent()) {
            header("Location:./private.php?ver=roles");
        } else {
            echo "<script type='text/javascript'>";
            echo "window.location.href='./private.php?ver=roles'";
            echo "</script>";
            exit;
        }
    }
}


//ELIMINAR ROLES
if (isset($_GET["borrarRoles"])) {
    $id = $_GET["id"];
    $dataBase->deleteRol($id);
    if (!headers_sent()) {
        header("Location:./private.php?ver=roles");
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location.href='./private.php?ver=roles'";
        echo "</script>";
        exit;
    }
}

//EDITAR ROLES
if (isset($_GET['editarRoles'])) {
    $id = $_GET['id'];
    if (!isset($_GET['cargarDatosEnviar'])) {
        $datosRol = $dataBase->showOneRol($id);
        $name = $datosRol["nombre"];
        $idParaEditar = $id;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
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
            padding: 10px;
            text-align: left;
        }

        .first {
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

        .create {
            /* border: 1px solid red; */
            display: flex;
            flex-direction: column;
            width: 100%;
        }
    </style>
    <script>
        function confirmBorrar(id, name) {
            if (confirm("Seguro que deseas borrar " + name)) {
                location.href = "private.php?ver=roles&borrarRoles&id=" + id;
            }
        }
    </script>
</head>

<body>
    <table class="tabla">
        <tr class="first">
            <td>ID</td>
            <td>Nombre</td>
            <td></td>
            <td></td>
        </tr>

        <?php
        //MOSTRAR LA TABLA
        foreach ($roles as $rol) {
        ?>
            <tr class="datos">
                <td>
                    <?php echo $rol[0] ?>
                </td>
                <td>
                    <?php echo $rol[1] ?>
                </td>
                <td class="accion">
                    <a href="private.php?ver=roles&id=<?php echo $rol[0] ?>&editarRoles">Editar</a>
                </td>
                <td class="accion">
                    <a href="#" onclick="confirmBorrar('<?php echo $rol[0] ?>','<?php echo $rol[1] ?>')">Borrar</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <!-- EL FORMULARIO PARA CREAR ROLES -->
    <div class="create">
        <h3>FORMULARIO PARA AÑADIR ROLES</h3>
        <form action="private.php?ver=roles" method="post">
            <p>Por favor inserta el nombre del rol</p>
            <input type="text" name="name" id="" value="<?php echo isset($name) ? $name : ''; ?>" required>
            <!-- HIDDEN PARA MANDAR DOS VECES EL EDITAR -->
            <input type="hidden" name="idSiEditar" value="<?php echo $idParaEditar ?? null ?>" required>
            <input type="submit" value="<?php echo isset($name) ? 'Editar rol' : 'Enviar'; ?>" name="enviarRoles">
        </form>
    </div>

</body>

</html>
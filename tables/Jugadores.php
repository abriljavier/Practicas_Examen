<?php
$allJugadores = $dataJugadores->showAllJugadores();
$allLigas = $dataLigas->showAllLigas();

//CREAR NUEVO USER
if (isset($_POST['createForm'])) {
    if (isset($_POST['idToEdit']) && ($_POST['idToEdit'] != "")) {
        $id = $_POST['idToEdit'];
        $newName = $_POST['name'];
        $liga = $_POST['liga'];
        $newImage = $_POST['imagen'];
        $data = [$id, $newName, $liga, $newImage];
        if ($dataJugadores->updateJugador($data)) {
            header("Location: ./private.php?showJugadores");
        } else {
            echo "Ha ocurrido un error";
        }
    } else {
        $nameJugador = $_POST['name'];
        $liga = $_POST['liga'];
        $imagenJugador = $_POST['imagen'];
        $data = [$nameJugador, $liga, $imagenJugador];
        if ($dataJugadores->createJugador($data)) {
            header("Location: ./private.php?showJugadores");
        } else {
            echo "Ha ocurrido un error";
        }
    }
}
//BORRAR UN USER
?>
<script>
    function confirmDelete(id, name) {
        if (confirm("¿Seguro que deseas eliminar el jugador " + name + " ?")) {
            location.href = "private.php?showJugadores&del&id=" + id;
        }
    }
</script>
<?php
if (isset($_GET['del'])) {
    $idToDelete = $_GET['id'];
    $data = [$idToDelete];
    if ($dataJugadores->deleteJugador($data)) {
        header("Location: ./private.php?showJugadores");
    }
}
//PRIMERA PARTE DE EDITAR
if (isset($_GET['edi'])) {
    $idToEdit = $_GET['id'];
    $data = [$idToEdit];
    $jugadorToEdit = $dataJugadores->getJugadorByID($data);
}


?>
<table class="tableContent">
    <tr class="first">
        <td>Nombre</td>
        <td>Liga</td>
        <td>Imagen</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($allJugadores as $jugador) {
        ?>
        <tr>
            <td>
                <?php echo $jugador['nombre'] ?>
            </td>
            <td>
                <?php echo $jugador['nombre_liga'] ?>
            </td>
            <td>
                <?php echo $jugador['img'] ?>
            </td>
            <td><a href="./private.php?showJugadores&edi&id=<?php echo $jugador['0'] ?>">Editar</a></td>
            <td><a onclick="confirmDelete('<?php echo $jugador['0'] ?>', '<?php echo $jugador['nombre'] ?>')"
                    href="">Borrar</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="formContainer">
    UTILIZA ESTE FORMULARIO PARA AÑADIR CAMPOS
    <p></p>
    <form action="./private.php?showJugadores" method="post" class="innerForm">
        Nombre<input type="text" name="name" id=""
            value="<?php echo isset($jugadorToEdit) ? $jugadorToEdit['nombre'] : "" ?>">
        <p></p>
        Liga <select name="liga" id="">
            <?php foreach ($allLigas as $liga) {
                ?>
                <option value="<?php echo $liga[0] ?>" <?php if (isset($userToEdit)) {
                       if ($jugadorToEdit['liga'] == $liga[0]) {
                           ?> selected <?php
                       }
                   } ?>>
                    <?php echo $liga[1] ?>
                </option>
                <?php
            } ?>
        </select>
        <p></p>
        Imagen<input type="text" name="imagen" id=""
            value="<?php echo isset($jugadorToEdit) ? $jugadorToEdit['img'] : "" ?>">
        <p></p>
        <input type="hidden" name="idToEdit" value="<?php echo isset($jugadorToEdit) ? $jugadorToEdit['id'] : "" ?>">
        <p></p>
        <input type="submit" value="Crear" name="createForm">
    </form>
</div>
<?php
?>
<?php
$allRoles = $dataRoles->showAllRoles();
// CREAR NUEVO ROL
if (isset($_POST['createForm'])) {
    if (isset($_POST['idToEdit']) && ($_POST['idToEdit'] != "")) {
        $id = $_POST['idToEdit'];
        $newRol = $_POST['name'];
        $data = [$id, $newRol];
        if ($dataRoles->updateRol($data)) {
            header("Location: ./private.php?showRoles");
        } else {
            echo "Ha ocurrido un error";
        }
    } else {
        $nameRol = $_POST['name'];
        $data = [$nameRol];
        if ($dataRoles->createRol($data)) {
            header("Location: ./private.php?showRoles");
        } else {
            echo "Ha ocurrido un error";
        }
    }
}
//BORRAR UN USER
?>
<script>
    function confirmDelete(id, name) {
        if (confirm("¿Seguro que deseas eliminar el rol " + name + " ?")) {
            location.href = "private.php?showRoles&del&id=" + id;
        }
    }
</script>
<?php
if (isset($_GET['del'])) {
    $idToDelete = $_GET['id'];
    $data = [$idToDelete];
    $dataRoles->deleteRol($data);
    header("Location: ./private.php?showRoles");
}
// //PRIMERA PARTE DE EDITAR
if (isset($_GET['edi'])) {
    $idToEdit = $_GET['id'];
    $data = [$idToEdit];
    $rolToEdit = $dataRoles->getRolByID($data);
}


?>
<table class="tableContent">
    <tr class="first">
        <td>Rol</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($allRoles as $rol) {
        ?>
        <tr>
            <td>
                <?php echo $rol['rol'] ?>
            </td>
            <td><a href="./private.php?showRoles&edi&id=<?php echo $rol['0'] ?>">Editar</a></td>
            <?php if ($rol['rol'] != 'admin') { ?>
                <td><a onclick="confirmDelete('<?php echo $rol['0'] ?>', '<?php echo $rol['rol'] ?>')" href="">Borrar</a>
                </td>
            <?php } ?>
        </tr>
        <?php
    }
    ?>
</table>
<div class="formContainer">
    UTILIZA ESTE FORMULARIO PARA AÑADIR CAMPOS
    <p></p>
    <form action="./private.php?showRoles" method="post" class="innerForm">
        Rol<input type="text" name="name" id="" value="<?php echo isset($rolToEdit) ? $rolToEdit['rol'] : "" ?>">
        <p></p>
        <input type="hidden" name="idToEdit" value="<?php echo isset($rolToEdit) ? $rolToEdit['id'] : "" ?>">
        <p></p>
        <input type="submit" value="Crear" name="createForm">
    </form>
</div>
<?php
?>
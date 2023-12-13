<?php
$allUsers = $dataUsuarios->showAllUsers();
$allRoles = $dataRoles->showAllRoles();
//CREAR NUEVO USER
if (isset($_POST['createForm'])) {
    if (isset($_POST['idToEdit']))
        $nameUser = $_POST['name'];
    $passwordUser = md5($_POST['password']);
    $rol = $_POST['rol'];
    $data = [$nameUser, $passwordUser, $rol];
    if ($dataUsuarios->createUser($data)) {
        header("Location: ./private.php?showUsuarios");
    } else {
        echo "Ha ocurrido un error";
    }
}
//BORRAR UN USER
?>
<script>
    function confirmDelete(id, name) {
        if (confirm("¿Seguro que deseas eliminar el usuario " + name + " ?")) {
            location.href = "private.php?showUsuarios&del&id=" + id;
        }
    }
</script>
<?php
if (isset($_GET['del'])) {
    $idToDelete = $_GET['id'];
    $data = [$idToDelete];
    $dataUsuarios->deleteUser($data);
}
//PRIMERA PARTE DE EDITAR
if (isset($_GET['edi'])) {
    $idToEdit = $_GET['id'];
    $data = [$idToEdit];
    $userToEdit = $dataUsuarios->getUserByID($data);
    print_r($userToEdit);
}


?>
<table class="tableContent">
    <tr class="first">
        <td>Nombre</td>
        <td>Password</td>
        <td>Rol</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($allUsers as $user) {
        ?>
        <tr>
            <td>
                <?php echo $user['usuario'] ?>
            </td>
            <td>
                <?php echo $user['password'] ?>
            </td>
            <td>
                <?php echo $user['rol'] ?>
            </td>
            <td><a href="./private.php?showUsuarios&edi&id=<?php echo $user['0'] ?>">Editar</a></td>
            <?php if ($user['rol'] != 'admin') { ?>
                <td><a onclick="confirmDelete('<?php echo $user['0'] ?>', '<?php echo $user['usuario'] ?>')" href="">Borrar</a>
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
    <form action="./private.php?showUsuarios" method="post" class="innerForm">
        Nombre<input type="text" name="name" id=""
            value="<?php echo isset($userToEdit) ? $userToEdit['usuario'] : "" ?>">
        <p></p>
        Password <input type="password" name="password" id=""
            value="<?php echo isset($userToEdit) ? $userToEdit['password'] : "" ?>">
        <p></p>
        Rol <select name="rol" id="">
            <?php foreach ($allRoles as $value) {
                ?>
                <option value="<?php echo $value[0] ?>" <?php if (isset($userToEdit)) {
                       if ($userToEdit['rol'] == $value[0]) {
                           ?> selected <?php
                       }
                   } ?>>
                    <?php echo $value[1] ?>
                </option>
                <?php
            } ?>
        </select>
        <input type="text" name="idToEdit" value="<?php echo isset($userToEdit) ? $userToEdit['id'] : "" ?>">
        <p></p>
        <input type="submit" value="Crear" name="createForm">
    </form>
</div>
<?php
?>
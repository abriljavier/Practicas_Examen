<?php
$allLigas = $dataLigas->showAllLigas();
//CREAR NUEVO USER
if (isset($_POST['createForm'])) {
    if (isset($_POST['idToEdit']) && ($_POST['idToEdit'] != "")) {
        $id = $_POST['idToEdit'];
        $name = $_POST['imagen'];
        $image = $_POST['imagen'];
        $data = [$id, $name, $image];
        if ($dataLigas->updateLiga($data)) {
            header("Location: ./private.php?showLigas");
        } else {
            echo "Ha ocurrido un error";
        }

    } else {
        $nameLiga = $_POST['name'];
        $imagenLiga = $_POST['imagen'];
        $data = [$nameLiga, $imagenLiga];

        //SUBIR UNA IMAGEN
        $target_dir = "./img/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $tem_dir = $_FILES["file"]["tmp_name"];
        if (move_uploaded_file($tem_dir, $target_file)) {
        } else {
            ?>
            <h1>La imagen no ha podido ser subida</h1>
            <?php
        }

        if ($dataLigas->createLiga($data)) {
            header("Location: ./private.php?showLigas");
        } else {
            echo "Ha ocurrido un error";
        }
    }
}
//BORRAR UN USER
?>
<script>
    function confirmDelete(id, name) {
        if (confirm("¿Seguro que deseas eliminar la liga " + name + " ?")) {
            location.href = "private.php?showLigas&del&id=" + id;
        }
    }
</script>
<?php
if (isset($_GET['del'])) {
    $idToDelete = $_GET['id'];
    $data = [$idToDelete];
    $dataLigas->deleteLiga($data);
}
//PRIMERA PARTE DE EDITAR
if (isset($_GET['edi'])) {
    $idToEdit = $_GET['id'];
    $data = [$idToEdit];
    $ligaToEdit = $dataLigas->getLigaByID($data);
}


?>
<table class="tableContent">
    <tr class="first">
        <td>Nombre</td>
        <td>imagen</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($allLigas as $liga) {
        ?>
        <tr>
            <td>
                <?php echo $liga['nombre_liga'] ?>
            </td>
            <td>
                <a href="#"><img src="./img/<?php echo $liga['imagen_liga'] ?>" width="50px" alt=""></a>
            </td>
            <td><a href="./private.php?showLigas&edi&id=<?php echo $liga['0'] ?>">Editar</a></td>
            <td><a onclick="confirmDelete('<?php echo $liga['0'] ?>', '<?php echo $liga['nombre_liga'] ?>')"
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
    <form action="./private.php?showLigas" method="post" class="innerForm" enctype="multipart/form-data">
        Nombre<input type="text" name="name" id=""
            value="<?php echo isset($ligaToEdit) ? $ligaToEdit['nombre_liga'] : "" ?>">
        <p></p>
        Imagen <input type="text" name="imagen" id=""
            value="<?php echo isset($ligaToEdit) ? $ligaToEdit['imagen_liga'] : "" ?>">
        <input type="file" name="file" id="file">
        <p></p>
        <input type="hidden" name="idToEdit" value="<?php echo isset($ligaToEdit) ? $ligaToEdit['id_liga'] : "" ?>">
        <p></p>
        <input type="submit" value="Crear" name="createForm">
    </form>
</div>
<?php
?>
<?php
include("./templates/header.php");
?>
<?php
if (isset($_GET['noSession'])) {
    session_start();
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['rol']);
    ?>
    <h3 style="color: red;">Hasta pronto!</h3>
    <?php
}
?>
<form action="private.php" method="post" class="form">
    <h5>Introduce su nombre de usuario y su password</h5>
    <input type="text" name="user" id="user" placeholder="user">
    <input type="password" name="password" id="password" placeholder="password">
    <input type="submit" value="Enviar" name="login">
</form>
<p></p>
<?php
include("./templates/footer.php");
?>
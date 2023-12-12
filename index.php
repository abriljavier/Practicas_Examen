<?php
include("./templates/header.php");
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
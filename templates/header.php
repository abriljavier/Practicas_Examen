<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practicas_Examen</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Practicas Examen</h1>
        <?php
        if (isset($_SESSION['user'])) {
            ?>
            <div>
                <a href="./index.php?noSession">Cerrar Sesión</a>
            </div>
            <?php
        }
        ?>

    </header>
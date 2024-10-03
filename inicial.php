<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site com Sidebar e Navbar</title>
    <link rel="stylesheet" href="Style/inicial.css">
</head>

<body>
    <?php include 'Elements/Nav.php' ?>

    <div class="main-container">
        <?php include 'Elements/SideBar.php' ?>
        <?php include 'Elements/Conteudo/Conteudo.php' ?>
    </div>
</body>

</html>
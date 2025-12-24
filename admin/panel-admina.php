<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-panele.css">
</head>

<body>
    <section class="panel">
        <a href="produkty.php">Produkty</a>
        <a href="kategorie.php">Kategorie</a>
        <a href="producent.php">Producenci</a>
        <a href="">Galeria zdjec</a>
        <a href="promocje.php">Promocje</a>
        <a href="sposob-dodania-promocji.php">Promocja-produkt</a>

        <a href="../zalogowany/zalogowany-index.php">Anuluj</a>
    </section>

    <?php
    include("../config/config.php");

    session_start();

    if (!isset($_SESSION['czy_admin']) || $_SESSION['czy_admin'] !== true) {
        header("Location: ../system-logowania/login.php");
        exit();
    }

    ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style/style-globalne.css">
    <link rel="stylesheet" href="style/style-indexes.css">
</head>

<body>
    <section class="pasek-glowny">
        <img src="assets/logo.png" alt="Logo strony" class="logo-strony">

        <input type="text" class="wyszukiwarka">

        <button class="szukaj">
            <img src="assets/szukaj.png" alt="">
        </button>

        <a href="system-logowania/login.php">
            <button class="konto">
                <img src="assets/konto.png" alt="">
            </button>
        </a>

        <a href="koszyk.php">
            <button class="koszyk">
                <img src="assets/koszyk.png" alt="">
            </button>
        </a>
    </section>

    <?php
        session_destroy();
    ?>
</body>

</html>
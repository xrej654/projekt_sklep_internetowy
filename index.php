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
    include("config/config.php");
    // usuwanie sesji aby pozbyc sie globalnej tabeli $_SESSION i zresetowanie danych
    if(session_status() != 2) session_destroy();

    // kod wyswietlajacy kategorie i produkty
    
    $tablicaKategorii = $connection->query("SELECT * FROM `kategoria`");

    sekcjaKategorii($tablicaKategorii, "index", true);

    if (empty($_GET['kategoria'])) {
        $produkty = $connection->query("SELECT * FROM `produkt`");
        produkt($produkty,"index.php",true);
    } else {
        $produkty = $connection->query("SELECT * FROM `produkt` JOIN kategoria USING(kategoria_id) WHERE kategoria = '{$_GET['kategoria']}'");
        produkt($produkty,"index.php",true);
    }
    ?>
</body>

</html>
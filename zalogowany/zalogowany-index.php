<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-indexes.css">
</head>

<body>
    <form method="post" action="zalogowany-index.php">
        <section class="pasek-glowny">
            <img src="../assets/logo.png" alt="Logo strony" class="logo-strony">

            <input type="text" name="tekst"
                value="<?php if (isset($_POST['tekst']))
                    echo htmlspecialchars($_POST['tekst']) ?>" class="wyszukiwarka">

                <button type="submit" name="szukaj" class="szukaj">
                    <img src="../assets/szukaj.png" alt="">
                </button>

                <a href="system-logowania/login.php">
                    <button type="button" class="konto">
                        <img src="../assets/konto.png" alt="">
                    </button>
                </a>

                <a href="../koszyk.php">
                    <button type="button" class="koszyk">
                        <img src="../assets/koszyk.png" alt="">
                    </button>
                </a>
            </section>
        </form>

        <?php
                include("../config/config.php");

                //start sesji aby miec dostep do tablicy $_SESSION i danych w niej zawartych
                session_start();

                //pobieranie nazwy uzytkownika i sprawdzanie czy dane konto jest kontem admina jesli tak to wyswietlaq sie specjalny przycisk
                $nazwa_uzytkownika = $_SESSION['nazwa_uzytkownika'];

                $query = "SELECT * FROM `konto` WHERE nazwa_uzytkownika='{$nazwa_uzytkownika}'";
                $wynik = $connection->query($query);
                $wiersz = $wynik->fetch_assoc();

                if ($wiersz['admin'] == 1) {
                    echo <<<ADMINBUTTON
                <a href="../admin/panel-admina.php">
                    <button class="admin">
                        <img src="../assets/admin.png">
                    </button>
                </a>
            ADMINBUTTON;
                }
                ?>
    </section>

    <?php
    // kod wyswietlajacy kategorie i produkty
    $tablicaKategorii = $connection->query("SELECT * FROM `kategoria`");

    sekcjaKategorii($tablicaKategorii, "zalogowany/zalogowany-index", false);

    if (isset($_POST['szukaj']) && isset($_POST['tekst'])) {
        $wyszukiwanyTekst = htmlspecialchars($_POST['tekst']);

        if (empty($_GET['kategoria'])) {
            $produkty = $connection->query("SELECT * FROM `produkt` WHERE nazwa LIKE '%{$wyszukiwanyTekst}%'");
            produkt($produkty, "zalogowany/zalogowany-index.php", false);
        } else {
            $produkty = $connection->query("SELECT * FROM `produkt` JOIN kategoria USING(kategoria_id) WHERE nazwa LIKE '%{$wyszukiwanyTekst}%' AND kategoria = '{$_GET['kategoria']}'");
            produkt($produkty, "zalogowany/zalogowany-index.php", false);
        }
    } else {
        if (empty($_GET['kategoria'])) {
            $produkty = $connection->query("SELECT * FROM `produkt`");
            produkt($produkty, "zalogowany/zalogowany-index.php", false);
        } else {
            $produkty = $connection->query("SELECT * FROM `produkt` JOIN kategoria USING(kategoria_id) WHERE kategoria = '{$_GET['kategoria']}'");
            produkt($produkty, "zalogowany/zalogowany-index.php", false);
        }
    }
    ?>

</body>

</html>
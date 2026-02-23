<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="style/style-globalne.css">
    <link rel="stylesheet" href="style/style-koszyk.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
</head>

<body>
    <?php
    include("config/config.php");

    session_start();

    error_reporting(E_ALL & ~E_WARNING);

    //obsluga przyciskow w koszyku
    if (isset($_POST['usun'])) {
        $connection->query("DELETE FROM `koszyk` WHERE koszyk_id = {$_POST['id']}");
        header("Location: koszyk.php");
    }

    if (isset($_POST['+'])) {
        $nowaIlosc = $_POST['ilosc'] + 1;

        $iloscProduktow = $connection->query("SELECT produkt.ilosc FROM `koszyk` JOIN `produkt` USING(produkt_id) WHERE koszyk_id = {$_POST['id']}")->fetch_assoc()['ilosc'];

        if ($nowaIlosc > $iloscProduktow)
            $nowaIlosc = $iloscProduktow;

        $connection->query("UPDATE `koszyk` SET ilosc = {$nowaIlosc} WHERE koszyk_id = {$_POST['id']}");
        header("Location: koszyk.php");
    }

    if (isset($_POST['-'])) {
        $nowaIlosc = $_POST['ilosc'] - 1;

        if ($nowaIlosc < 1)
            $nowaIlosc = 1;

        $connection->query("UPDATE `koszyk` SET ilosc = {$nowaIlosc} WHERE koszyk_id = {$_POST['id']}");
        header("Location: koszyk.php");
    }

    //zaleznosc linku do powrotu z koszyka w zaleznosci od sesji
    if (isset($_SESSION['nazwa_uzytkownika']))
        echo "<a href=\"zalogowany/zalogowany-index.php\">Anuluj</a>";
    else
        echo "<a href=\"index.php\">Anuluj</a>";

    //wyswietlanie kazdego produktu w koszyku
    if (isset($_SESSION['klient_id'])) {
        $produktyZKoszyka = $connection->query("SELECT produkt_id, koszyk_id, fotografia, nazwa, cena, koszyk.ilosc FROM `koszyk` JOIN `produkt` USING(produkt_id) WHERE klient_id = {$_SESSION['klient_id']}");

        echo "<section class=\"koszyk\">";

        $cena = 0;

        while ($produktZKoszyka = $produktyZKoszyka->fetch_assoc()) {
            $fotografia = substr($produktZKoszyka['fotografia'], 3);

            //obliczanie promocji
            $obnizka = $connection->query("SELECT obnizka_ceny FROM `promocja_produkt` JOIN `promocja` USING(promocja_id) WHERE produkt_id = '{$produktZKoszyka['produkt_id']}'")->fetch_assoc()['obnizka_ceny'];
            $cenaProduktu = ($produktZKoszyka['cena'] - $produktZKoszyka['cena'] * ($obnizka / 100)) * $produktZKoszyka['ilosc'];
            $cena += $cenaProduktu;

            echo <<<PRODUKT
                <div class="produkt">
                    <form method="post">
                        <div class="zdjecie">
                            <img src="{$fotografia}" alt="zdjecie produktu">
                        </div>
                        <div class="dane">
                            {$produktZKoszyka['nazwa']} <br> <br>
                            {$cenaProduktu} zl
                        </div>
                        <div class="ilosc">
                            <button type="submit" name="+" class="zmiana-ilosci">+</button> <br>
                            {$produktZKoszyka['ilosc']} <br>
                            <button type="submit" name="-" class="zmiana-ilosci">-</button>
                        </div>
                        <div class="usun">
                            <button type="submit" name="usun">Usun</button>
                        </div>
                            <input type="hidden" name="id" value="{$produktZKoszyka['koszyk_id']}">
                            <input type="hidden" name="ilosc" value="{$produktZKoszyka['ilosc']}">
                    </form>
                </div>
                <br>
            PRODUKT;
        }

        echo "<a class=\"cenaFinalna\">$cena zl</a> <br>";
        echo "<a href=\"zloz-zamowienie.php\">Zamow</a>";

        echo "</section>";
    }
    ?>
</body>

</html>
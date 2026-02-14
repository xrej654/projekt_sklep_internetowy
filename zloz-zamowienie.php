<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="style/style-globalne.css">
    <link rel="stylesheet" href="style/style-zloz-zamowienie.css">
    <link rel="shortcut icon" href="../../assets/logo.png" type="image/x-icon">
</head>

<body>
    <?php
    include("config/config.php");

    session_start();


    //zaleznosc linku do powrotu z koszyka w zaleznosci od sesji
    if (isset($_SESSION['nazwa_uzytkownika']))
        echo "<a href=\"zalogowany/zalogowany-index.php\">Anuluj</a>";
    else
        echo "<a href=\"index.php\">Anuluj</a>";

    echo "<section class=\"zamowienie\">";

    //w zalezniosci od sesji cofamy do roznych plikow
    if (isset($_POST['pomin'])) {
        if (isset($_SESSION['nazwa_uzytkownika']))
            header("Location: zalogowany/zalogowany-index.php");
        else
            header("Location: index.php");
    }

    //kod na dodanie opini o sklepie (ankieta)
    if (isset($_POST['dodaj']) && isset($_POST['ocena']) && isset($_POST['komentarz'])) {
        $zamowienie_id = $connection->query("SELECT zamowienie_id FROM `zamowienie` ORDER BY zamowienie_id DESC LIMIT 1")->fetch_assoc()['zamowienie_id'];
        $data = date('Y-m-d H:i:s');

        $connection->query("INSERT INTO `ankieta` (zamowienie_id, ocena, komentarz, data) VALUES ({$zamowienie_id}, '{$_POST['ocena']}', '{$_POST['komentarz']}', '{$data}')");

        if (isset($_SESSION['nazwa_uzytkownika']))
            header("Location: zalogowany/zalogowany-index.php");
        else
            header("Location: index.php");
    } else if (isset($_POST['dodaj'])) {
        blokBledu("Uzupelnij pola", "zloz-zamowienie.php", "assets/x.png");
    }

    //kod ktory jest odpowiedzialny za ustawianie bazy danych oraz wyswietlenie ankiety
    if (isset($_POST['zaplac']) && isset($_POST['platnosc']) && isset($_POST['wysylka'])) {
        echo "[Symulacja platnosci]";

        $cenaLaczna = 0;
        $data = date('Y-m-d H:i:s');

        //date jest to funkcja do zdobycia daty z czasem (typ datetime w bazie danych) w nawiasach jest format
        $connection->query("INSERT INTO `zamowienie` (klient_id, data_zlozenia_zamowienia,czy_zaplacono, status, sposob_wysylki, sposob_platnosci, cena_laczna) VALUES ({$_SESSION['klient_id']}, '{$data}', 'true', 'nie wyslano', '{$_POST['wysylka']}', '{$_POST['platnosc']}', '{$cenaLaczna}')");

        $zamowienie_id = $connection->query("SELECT zamowienie_id FROM `zamowienie` ORDER BY zamowienie_id DESC LIMIT 1")->fetch_assoc()['zamowienie_id'];

        $produktyZKoszyka = $connection->query("SELECT produkt_id, cena, koszyk.ilosc FROM `koszyk` JOIN `produkt` USING(produkt_id) WHERE klient_id = {$_SESSION['klient_id']}");

        while ($produktZKoszyka = $produktyZKoszyka->fetch_assoc()) {
            $obnizka = $connection->query("SELECT obnizka_ceny FROM `promocja_produkt` JOIN `promocja` USING(promocja_id) WHERE produkt_id = '{$produktZKoszyka['produkt_id']}'")->fetch_assoc()['obnizka_ceny'];
            $cenaLaczna += ($produktZKoszyka['cena'] - $produktZKoszyka['cena'] * ($obnizka / 100)) * $produktZKoszyka['ilosc'];

            $connection->query("INSERT INTO `zamowienie_produkt` (zamowienie_id, produkt_id, ilosc) VALUES ({$zamowienie_id}, {$produktZKoszyka['produkt_id']}, {$produktZKoszyka['ilosc']})");
        }

        $connection->query("UPDATE `zamowienie` SET cena_laczna = {$cenaLaczna} WHERE zamowienie_id = {$zamowienie_id}");

        echo "<form method=\"post\"> <br><select name=\"ocena\">";
        echo "<option value=\"0.0\" selected>0.0</option>";

        for ($i = 0.5; $i <= 5.0; $i += 0.5) {
            if ($i != 1 * floor($i))
                echo "<option value=\"{$i}\">{$i}</option>";
            else
                echo "<option value=\"{$i}.0\">{$i}.0</option>";
        }

        echo "</select><br>";
        echo "<textarea name=\"komentarz\"></textarea> <br> <button type=\"submit\" name=\"pomin\">Pomin</button> <button type=\"submit\" name=\"dodaj\">Dodaj</button> </form>";
    } else if (isset($_POST['wybierz_platnosc']) && isset($_POST['wysylka'])) {
        //kod wyswietlajacy wybor metody platnosci
        echo "<form method=\"post\">";

        echo "Blik: <input type=\"checkbox\" name=\"platnosc\" value=\"blik\"> <br>";
        echo "PayPal: <input type=\"checkbox\" name=\"platnosc\" value=\"paypal\"> <br>";
        echo "Karta: <input type=\"checkbox\" name=\"platnosc\" value=\"karta\"> <br>";
        echo "Apple pay: <input type=\"checkbox\" name=\"platnosc\" value=\"applepay\"> <br>";
        if ($_POST['wysylka'] == "kurier")
            echo "Przy odbiorze: <input type=\"checkbox\" name=\"platnosc\" value=\"przy odbiorze\"> <br>";

        echo "<input type=\"hidden\" name=\"wysylka\" value=\"{$_POST['wysylka']}\">";

        echo "<button type=\"submit\" name=\"wstecz\">Wstecz</button>";
        echo "<button type=\"submit\" name=\"zaplac\">Zaplac</button>";
        echo "</form>";
    } else if (isset($_POST['wybierz_platnosc']) && !isset($_POST['wysylka'])) {
        blokBledu("Wybierz wysylke", "zloz-zamowienie.php", "assets/x.png");
    } else if (true || isset($_POST['wstecz'])) {
        //kod ktory umozliwia wybor sposob wysylki    
        echo "<form method=\"post\">";

        echo "DPD: <input type=\"checkbox\" name=\"wysylka\" value=\"dpd\"> <br>";
        echo "Kurier: <input type=\"checkbox\" name=\"wysylka\" value=\"kurier\"> <br>";
        echo "Inpost: <input type=\"checkbox\" name=\"wysylka\" value=\"inpost\"> <br>";
        echo "Orlen paczka: <input type=\"checkbox\" name=\"wysylka\" value=\"orlen paczka\"> <br>";

        echo "<button type=\"submit\" name=\"wybierz_platnosc\">Dalej</button>";
        echo "</form>";
    }

    echo "</section>";
    ?>
</body>

</html>
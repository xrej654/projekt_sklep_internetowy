<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-globalne.css">
    <link rel="stylesheet" href="style/style-produkt.css">
    <title>Sklep internetowy</title>
</head>

<body>
    <?php
    include("config/config.php");

    error_reporting(E_ALL & ~E_WARNING);

    session_start();

    //pobieranie danych
    $nazwa = htmlspecialchars($_GET['nazwa']);
    $produkt = $connection->query("SELECT * FROM `produkt` JOIN `producent` USING(producent_id) JOIN `kategoria` USING(kategoria_id) WHERE nazwa = '{$nazwa}'")->fetch_assoc();
    $galeria = $connection->query("SELECT link FROM `zdjecia` WHERE produkt_id={$produkt['produkt_id']}");

    //obslga zdarzen do oceny produktow
    if (isset($_POST['submit'])) {
        $ocena = $_POST['ocena'];
        $komentarz = htmlspecialchars($_POST['komentarz']);
        $produkt_id = $produkt['produkt_id'];

        $konto_id = $connection->query("SELECT konto_id FROM `konto` WHERE nazwa_uzytkownika='{$_SESSION['nazwa_uzytkownika']}'")->fetch_assoc();

        $query = "INSERT INTO `ocena` (ocena, komentarz, produkt_id, konto_id) VALUES ('{$ocena}','{$komentarz}',{$produkt_id}, {$konto_id['konto_id']})";
        $connection->query($query);

        header("Location: produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
    }

    if (isset($_POST['usun'])) {
        $connection->query("DELETE FROM `ocena` WHERE ocena_id={$_POST['id']}");

        header("Location: produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
    }

    if (isset($_POST['zmien'])) {
        $komentarz = htmlspecialchars($_POST['nowy_komentarz']);
        $connection->query("UPDATE `ocena` SET ocena='{$_POST['nowa_ocena']}', komentarz='{$komentarz}' WHERE ocena_id='{$_POST['id']}'");

        header("Location: produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
    }

    //pobieranie oraz wpisywanie danych klienta
    if (isset($_POST['dane'])) {
        if (isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['adres']) && isset($_POST['nrTelefonu']) && isset($_POST['email']) && empty($_SESSION['klient_id'])) {
            $imie = htmlspecialchars($_POST['imie']);
            $nazwisko = htmlspecialchars($_POST['nazwisko']);
            $adres = htmlspecialchars($_POST['adres']);
            $nrTel = htmlspecialchars($_POST['nrTelefonu']);
            $email = htmlspecialchars($_POST['email']);

            if ($connection->query("INSERT INTO `klient` (imie, nazwisko, adres, nr_telefonu, email) VALUES ('{$imie}', '{$nazwisko}', '{$adres}', '{$nrTel}', '{$email}')")) {
                $_SESSION['klient_id'] = $connection->query("SELECT klient_id FROM `klient` ORDER BY klient_id DESC LIMIT 1")->fetch_assoc()['klient_id'];
                header("Location: produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
            } else {
                blokBledu("Istnieje juz klient z tym emailem", "produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
            }
        }
    }

    echo "<a href=\"{$_GET['link']}\">Anuluj</a> <br><br>";

    //wyswietlanie formularza do podania danych klienta, dodanie produktu do koszyka oraz wyswietlanie produktu
    if ($_POST['czyKoszyk'] && empty($_SESSION['klient_id'])) {
        echo <<<DANEDOKOSZYKA
            <section class="koszyk">
                <form method="post">
                    Imie: <input type="text" name="imie"> <br>
                    Nazwisko: <input type="text" name="nazwisko"> <br>
                    Adres: <input type="text" name="adres"> <br>
                    Nr. Tel.: <input type="text" name="nrTelefonu"> <br>
                    Email: <input type="text" name="email"> <br>
                    <button type="submit" name="dane">Dodaj dane</button>
                </form>    
            </section>
        DANEDOKOSZYKA;
    } else if ($_POST['czyKoszyk'] && isset($_SESSION['klient_id'])) {
        $dane = $connection->query("SELECT klient_id, produkt_id FROM `koszyk`");
        $czyMoznaDodac = true;

        while ($dana = $dane->fetch_assoc()) {
            if ($dana['klient_id'] == $_SESSION['klient_id'] && $dana['produkt_id'] == $produkt['produkt_id']) {
                $czyMoznaDodac = false;
                break;
            }
        }

        if ($czyMoznaDodac)
            $connection->query("INSERT INTO `koszyk` (klient_id, produkt_id, ilosc) VALUES ({$_SESSION['klient_id']}, {$produkt['produkt_id']} , 1)");

        header("Location: produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
    } else {
        if (empty($_POST['zdjecie']))
            $fotografia = substr($produkt['fotografia'], 3);
        else
            $fotografia = $_POST['zdjecie'];

        echo <<<PRODUKTCZ1
    <section class="produkt">
        <div class="lewy-panel">
            <div class="zdjecie">
                <img src="{$fotografia}" alt="fotografia">
            </div>
            <div class="galeria">
    PRODUKTCZ1;

        echo "<form method=\"post\" action=\"produkt.php?nazwa={$nazwa}&link={$_GET['link']}\">";
        while ($zdjecie = $galeria->fetch_assoc()) {
            $link = substr($zdjecie['link'], 3);
            echo "<button type=\"submit\" name=\"zdjecie\" value=\"{$link}\"><img src=\"{$link}\"></button>";
        }
        echo "</form>";

        echo <<<PRODUKTCZ2
            </div>
        </div>
        <div class="prawy-panel">
            <div class="info">
                <div class="nazwa">
                    {$produkt['nazwa']}
                </div>
                <div class="opis">
                    {$produkt['opis']}
                </div>
                <div class="cena">
                    {$produkt['cena']} zl
                </div>
                <div class="ilosc">
                    {$produkt['ilosc']} szt.
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="dodatki">
                <form method="post" action="produkt.php?nazwa={$nazwa}&link={$_GET['link']}">
                <button type="submit" name="czyOpinie" value="true">Opinie</button>
                <button type="submit" name="czyDodacOpinie" value="true" style="margin-right:10vw;">Dodaj opinie</button>
        PRODUKTCZ2;

        //sprawdzanie czy produkt jest dostepny
        if ($produkt['ilosc'] != 0)
            echo "<button type=\"submit\" name=\"czyKoszyk\" value=\"true\">Dodaj do koszyka</button>";
        else
            echo "Produkt nie dostepny";
        echo "</form> </div> </div> </section>";

        //kod do dodania i wyswietlania opinii
        if (isset($_POST['czyOpinie']) || isset($_POST['czyDodacOpinie']) || isset($_POST['edytuj'])) {
            $opinie = $connection->query("SELECT * FROM `ocena` JOIN `konto` USING(konto_id) JOIN `produkt` USING(produkt_id) WHERE produkt.nazwa = '{$nazwa}'");

            if (isset($_POST['czyDodacOpinie']))
                $wysokosc = ($opinie->num_rows + 1) * 15;
            else
                $wysokosc = $opinie->num_rows * 15;

            echo "<section class=\"opinie\" style=\"height:{$wysokosc}vh\">";

            while ($opinia = $opinie->fetch_assoc()) {
                echo "<form method=\"post\"";
                echo "<div class=\"opinia\">";
                echo "<div class=\"panel-lewy\">";
                echo "<img src=\"assets/konto.png\"> <br>";
                echo htmlspecialchars($opinia['nazwa_uzytkownika']);
                echo "</div> <div class=\"panel-prawy\">";
                if (isset($_POST['edytuj']) && $opinia['ocena_id'] == $_POST['id']) {
                    echo "<select name=\"nowa_ocena\">";
                    echo "<option value=\"0.0\" selected>0.0</option>";

                    for ($i = 0.5; $i <= 5.0; $i += 0.5) {
                        if ($i != 1 * floor($i))
                            echo "<option value=\"{$i}\">{$i}</option>";
                        else
                            echo "<option value=\"{$i}.0\">{$i}.0</option>";
                    }

                    echo "</select><br>";
                    echo "<textarea name=\"nowy_komentarz\" value=\"{$opinia['komentarz']}\">{$opinia['komentarz']}</textarea>";
                } else {
                    echo "{$opinia['ocena']}/5.0 <br>";
                    echo "{$opinia['komentarz']}";
                }

                if ($opinia['nazwa_uzytkownika'] == $_SESSION['nazwa_uzytkownika'] && !isset($_POST['edytuj'])) {
                    echo "<br><button name=\"usun\" type=\"submit\">Usun opinie</button>";
                    echo "<button name=\"edytuj\" type=\"submit\">Edytuj opinie</button>";
                } else if ($opinia['nazwa_uzytkownika'] == $_SESSION['nazwa_uzytkownika']) {
                    echo "<br><button name=\"zmien\" type\"submit\">Zmien</button>";
                }

                echo "<input type=\"hidden\" name=\"id\" value=\"{$opinia['ocena_id']}\">";
                echo "</div></div></form>";
            }

            if (isset($_POST['czyDodacOpinie']) && isset($_SESSION['nazwa_uzytkownika'])) {
                echo "<form method=\"post\">";
                echo "<div class=\"opinia\">";
                echo "<div class=\"panel-lewy\">";
                echo "<img src=\"assets/konto.png\"> <br>";
                echo htmlspecialchars($_SESSION['nazwa_uzytkownika']);
                echo "</div> <div class=\"panel-prawy\">";
                echo "<select name=\"ocena\">";
                echo "<option value=\"0.0\" selected>0.0</option>";

                for ($i = 0.5; $i <= 5.0; $i += 0.5) {
                    if ($i != 1 * floor($i))
                        echo "<option value=\"{$i}\">{$i}</option>";
                    else
                        echo "<option value=\"{$i}.0\">{$i}.0</option>";
                }

                echo "</select><br>";
                echo "<textarea name=\"komentarz\"></textarea><br>";
                echo "<button type=\"submit\" name=\"submit\">Dodaj</button>";
                echo "</div></div></form>";
            } else if (isset($_POST['czyDodacOpinie'])) {
                blokBledu("Utworz konto aby dodac opinie", "produkt.php?nazwa={$nazwa}&link={$_GET['link']}");
            }

            echo "</section>";
        }
    }

    ?>
</body>

</html>
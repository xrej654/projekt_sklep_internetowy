<?php
//zapis danych do polaczenie z baza i polaczenie z baza
$host = "localhost";
$user = "root";
$password = "";
$database = "sklep internetowy";

$connection = new mysqli($host, $user, $password, $database);

//sprawdzenie czy polaczenie sie udalo
if ($connection->connect_error) {
    die("Błąd połączenia: " . $connection->connect_error);
}

//funkcja wyswietlajaca wiadomosc bledu
function blokBledu($wiadomosc, $link, $linkAssetuX)
{
    echo <<<BLOKBLEDU
                        <form action="{$link}">
                            <div class="error-block">
                                <button type="submit">
                                    <img src="{$linkAssetuX}">
                                </button>
                                <p>
                                    {$wiadomosc}
                                </p>
                            </div>
                        </form>
            BLOKBLEDU;
}

// funckja wyswietlajaca wszystkie kategorie i umozliwia wybranie kategorii ktora chcemy przejrzec
function sekcjaKategorii($tablicaKategorii, $plik, $czyZmienicLink)
{
    echo "<section class=\"pole-kategorii\">";

    while ($kategoria = $tablicaKategorii->fetch_assoc()) {
        if ($czyZmienicLink)
            $link = substr($kategoria["ikona"], 3);
        else
            $link = $kategoria["ikona"];
        echo <<<SEKCJAKATEGORII
            <a href="{$plik}.php?kategoria={$kategoria["kategoria"]}">
                <div class="kategoria">
                    <img src="{$link}" alt="zdjecie kategorii">
                    <br>
                    {$kategoria["kategoria"]}
                </div>
            </a>
        SEKCJAKATEGORII;
    }

    echo "</section>";
}

// funkcja wyswietlajaca produkty
function produkt($produkty, $plik, $czyZmienicLink, $baza)
{
    $wysokosc = ceil($produkty->num_rows / 4) * 190;

    echo "<section class=\"produkty\" style=\"height:{$wysokosc}px\">";

    while ($produkt = $produkty->fetch_assoc()) {
        if ($czyZmienicLink) {
            $link = substr($produkt["fotografia"], 3);
            $stronaProduktu = "produkt.php?nazwa={$produkt['nazwa']}&link={$plik}";
        } else {
            $link = $produkt["fotografia"];
            $stronaProduktu = "../produkt.php?nazwa={$produkt['nazwa']}&link={$plik}";
        }

        //obliczanie obnizki ceny
        //zmienna $baza jest potrzebna bo jak uzyjemy $connection to jest blad ze nie jest ona zainicjalizowana
        $obnizka = $baza->query("SELECT obnizka_ceny FROM `promocja_produkt` JOIN `promocja` USING(promocja_id) WHERE produkt_id = '{$produkt['produkt_id']}'")->fetch_assoc()['obnizka_ceny'];
        $cena = $produkt['cena'] - $produkt['cena'] * ($obnizka / 100);

        echo <<<SEKCJAPRODUKTOW
            <a href="{$stronaProduktu}">
                <div class="produkt">
                    <div class="zdjecie">
                        <img src="{$link}" alt="zdjecie produktu">
                    </div>
                    <div class="info">
                        {$produkt['nazwa']}
                        <br>
                        {$cena} zl   
                    </div>
                </div>
            </a>    
            SEKCJAPRODUKTOW;
    }

    echo "</section>";
}
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
    $nazwa = htmlspecialchars($_GET['nazwa']);
    $produkt = $connection->query("SELECT * FROM `produkt` JOIN `producent` USING(producent_id) JOIN `kategoria` USING(kategoria_id) WHERE nazwa = '{$nazwa}'")->fetch_assoc();
    $galeria = $connection->query("SELECT link FROM `zdjecia` WHERE produkt_id={$produkt['produkt_id']}");

    echo "<a href=\"{$_GET['link']}\">Anuluj</a> <br><br>";

    if(empty($_POST['zdjecie'])) $fotografia = substr($produkt['fotografia'],3);
    else $fotografia = $_POST['zdjecie'];

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
        $link = substr($zdjecie['link'],3);
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
            </div>
            <br>
            <br>
            <br>
            <div class="dodatki">
                <form method="post" action="produkt.php?nazwa={$nazwa}&link={$_GET['link']}">
                <button type="submit" name="czyOpinie" value="true">Opinie</button>
                <button type="submit" name="czyKoszyk" value="true">Dodaj do koszyka</button>
                </form>
            </div>
        </div>
    </section>
    PRODUKTCZ2;
    ?>
</body>

</html>
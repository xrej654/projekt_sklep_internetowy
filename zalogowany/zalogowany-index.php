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
    <section class="pasek-glowny">
        <img src="../assets/logo.png" alt="Logo strony" class="logo-strony">

        <input type="text" class="wyszukiwarka">

        <button class="szukaj">
            <img src="../assets/szukaj.png" alt="">
        </button>

        <a href="edytuj-konto.php">
            <button class="konto">
                <img src="../assets/konto.png" alt="">
            </button>
        </a>

        <a href="koszyk.php">
            <button class="koszyk">
                <img src="../assets/koszyk.png" alt="">
            </button>
        </a>

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

</body>

</html>
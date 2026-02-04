<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style/style-globalne.css">
    <link rel="stylesheet" href="../../style/style-zmiana.css">
    <link rel="stylesheet" href="../../style/style-wspolne-formularze.css">
    <link rel="stylesheet" href="../../style/style-wspolne-zmiana-edytuj-konto.css">
</head>

<body>
    <section class="zmiana">
        <div class="kolumna-lewa">
            <div class="img-background">
                <img src="../../assets/konto.png">
            </div>

            <div class="nazwa-uzytkownika">
                <?php session_start(); //zdobycie dostepu do $_SESSION i wysietlenie nazwy a nastepnej wstawce php wpisanie podstawowej wartosci poa jako stara nazwa uzytkownika
                echo htmlspecialchars($_SESSION['nazwa_uzytkownika']); ?>
            </div>
        </div>

        <div class="kolumna-prawa">
            <form method="post">
                Podaj nowy login: <br> <input type="text" name="nowy_login"
                    value="<?php echo htmlspecialchars($_SESSION['nazwa_uzytkownika']); ?>">
                <br>
                <button type="submit" name="submit">Zmien</button>
                <br>
                <a href="../edytuj-konto.php">Anuluj</a>
            </form>
        </div>
    </section>

    <?php
    include("../../config/config.php");

    //sprawdzamy czy uzytkownik wpisal cokolwiek do pola
    if (!empty($_POST['nowy_login'])) {
        $aktualnyLogin = $_SESSION['nazwa_uzytkownika'];

        if ($_POST['nowy_login'] !== $aktualnyLogin) {
            //podmiana nazwy
            $nowyLogin = htmlspecialchars($_POST['nowy_login']); //funkcja ktora chroni przed nazwami jako wstawki kodu (szyfruje znaki)
            $query = "UPDATE `konto` SET nazwa_uzytkownika = '{$nowyLogin}' WHERE nazwa_uzytkownika = '{$aktualnyLogin}'";
            $connection->query($query);

            $_SESSION["nazwa_uzytkownika"] = $nowyLogin;

            header("Location: ../edytuj-konto.php"); //funkcja przenoszaca do innego pliku
        } else {
            blokBledu("Loginy nie moga byc takie same", "zmien-login.php"); //wlasna funkcja wyswietlajaca komunikat z bledem
        }
    } else if (empty($_POST['nowy_login']) && isset($_POST['submit'])) { //wyswietlanie bledu jezeli nazwa uzytkownika jest pusta i uzytkownik podmienial nazwe
        blokBledu("Prosze wypelnic pola", "zmien-login.php");
    }
    ?>
</body>

</html>
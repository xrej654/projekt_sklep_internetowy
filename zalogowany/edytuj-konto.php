<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assest/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-wspolne-zmiana-edytuj-konto.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
</head>

<body>
    <section class="edytuj-konto">
        <div class="kolumna-lewa">
            <div class="img-background">
                <img src="../assets/konto.png">
            </div>

            <div class="nazwa-uzytkownika">
                <?php session_start(); //zdobycie dostepu do $_SESSION i wyswietlenie nazwy uzytkownika
                echo htmlspecialchars($_SESSION['nazwa_uzytkownika']); ?>
            </div>
        </div>

        <div class="kolumna-prawa">
            <a href="zmiany/zmien-login.php">Zmien nazwe uzytkownika</a>
            <a href="zmiany/zmien-haslo.php">Zmien haslo</a>
            <a href="zalogowany-index.php">Anuluj</a>
            <a href="../index.php">Wyloguj</a>
        </div>
    </section>
</body>

</html>
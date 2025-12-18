<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-zmiana.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
    <link rel="stylesheet" href="../style/style-wspolne-zmiana-edytuj-konto.css">
</head>

<body>
    <section class="zmiana">
        <div class="kolumna-lewa">
            <div class="img-background">
                <img src="../assets/konto.png">
            </div>

            <div class="nazwa-uzytkownika">
                <?php session_start();
                echo htmlspecialchars($_SESSION['nazwa_uzytkownika']); ?>
            </div>
        </div>

        <div class="kolumna-prawa">
            <form method="post">
                Podaj stare haslo: <br> <input type="password" name="stare_haslo">
                <br>
                Podaj nowe haslo: <br> <input type="password" name="nowe_haslo">
                <br>
                <button type="submit">Zmien</button>
                <br>
                <a href="edytuj-konto.php">Anuluj</a>
            </form>
        </div>
    </section>

    <?php
    include('../config/config.php');

    if (!empty($_POST['stare_haslo']) && !empty($_POST['nowe_haslo'])) {
        $query = "SELECT * FROM `konto` WHERE nazwa_uzytkownika='{$_SESSION['nazwa_uzytkownika']}'";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();

        if ($row['haslo'] === $_POST['nowe_haslo'] || $_POST['stare_haslo'] === $_POST['nowe_haslo']) {
            errorBlock("Nowe haslo nie moze byc takie same jak stare", "zmien-haslo.php");
        } else if ($row['haslo'] === $_POST["stare_haslo"] && $_POST['nowe_haslo'] !== $row['haslo']) {
            $noweHaslo = htmlspecialchars($_POST['nowe_haslo']);
            $query = "UPDATE `konto` SET haslo='{noweHaslo}' WHERE nazwa_uzytkownika='{$_SESSION['nazwa_uzytkownika']}'";
            $connection->query($query);

            header("Location: edytuj-konto.php");
        } else {
            errorBlock("Haslo jest nie zgodne", "zmien-haslo.php");
        }
    } else if ((empty($_POST['stare_haslo']) || empty($_POST['nowe_haslo'])) && isset($_POST["submit"])) {
        errorBlock("Prosze wypelnic pola", "zmien-haslo.php");
    }

    $connection->close();
    ?>
</body>

</html>
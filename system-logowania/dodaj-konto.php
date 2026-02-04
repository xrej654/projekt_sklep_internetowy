<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-dodaj-konto.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
</head>

<body>
    <section class="nowe-konto">
        <form method="post">
            <div class="kolumna-lewa">
                Login:<input type="text" name="login">
                Email:<input type="email" name="email">
                <a href="login.php">Cofnij</a>
            </div>

            <div class="kolumna-prawa">
                Haslo: <input type="password" name="haslo">
                Powtorz haslo: <input type="password" name="powtorz_haslo">
                <button type="submit" name="submit">Utworz</button>
            </div>
        </form>
    </section>

    <?php
    include("../config/config.php");

    session_start();

    if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['haslo']) && !empty($_POST['powtorz_haslo'])) { //sprawdzenie czy pola nie sa puste
        $login = htmlspecialchars($_POST['login']);
        $email = htmlspecialchars($_POST['email']);
        $haslo = htmlspecialchars($_POST['haslo']);
        $powtorz_haslo = htmlspecialchars($_POST['powtorz_haslo']);

        //sprawdzamy czy uzytkownik powtorzyl dobrze haslo i czy ma dobra dlugosc
        if ($haslo != $powtorz_haslo) {
            errorBlock("Hasla sie nie zgadzaja", "dodaj-konto.php");
        } else if (strlen($haslo) < 8) {
            errorBlock("Haslo jest za krotkie", "dodaj-konto.php");
        } else {
            //sprawdzabnie czy istnieje podany uzytkownik o podanej nazwie
            $istnieje = false;

            $query = "SELECT * FROM `konto`";
            $wynik = $connection->query($query);

            while ($wiersz = $wynik->fetch_assoc()) {
                if ($login === $wiersz['nazwa_uzytkownika']) {
                    $istnieje = true;
                    break;
                }
            }

            //dodawanie uzytkownika do bazy
            if (!$istnieje) {
                $query = "INSERT INTO `konto` (nazwa_uzytkownika, haslo, email) VALUES ('$login', '$haslo', '$email')";

                $connection->query($query);

                $_SESSION["nazwa_uzytkownika"] = $login; //wpisywanie danych do sesji
                header("Location: ../zalogowany/zalogowany-index.php"); //przekierowywanie do innego piku
            //wyswietlanie bledow jesli cos uzytkowik zrobi zle
            } else {
                errorBlock("Istnieje juz taki uzytkownik", "dodaj-konto.php");
            }
        }
    } else if ((empty($_POST['login']) || empty($_POST['email']) || empty($_POST['haslo']) || empty($_POST['powtorz_haslo'])) && isset($_POST['submit'])) {
        errorBlock("Prosze wypelnic wszytkie pola", "dodaj-konto.php");
    }

    $connection->close();
    ?>

</body>

</html>
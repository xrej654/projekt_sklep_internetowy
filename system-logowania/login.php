<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
    <link rel="stylesheet" href="../style/style-login.css">
</head>

<body>
    <section class="login">
        <form method="post">
            <div class="kolumna-lewa">
                Login:<input type="text" name="login">
                Haslo:<input type="password" name="haslo">
                <a href="../index.php">Anuluj</a>
            </div>

            <div class="kolumna-prawa">
                <a href="dodaj-konto.php">Nie mam konta</a>
                <a href="">Zapomnialem haslo</a>
                <button type="submit" name="submit">Zaloguj</button>
            </div>
        </form>
    </section>

    <?php
    include("../config/config.php");

    session_start();

    if (!empty($_POST['login']) && !empty($_POST['haslo'])) { //sprawdzanie czy pola nie sa puste
        $login = htmlspecialchars($_POST['login']);
        $haslo = htmlspecialchars($_POST['haslo']);
        $istnieje = false;

        //sprawdzenie czy konto istnieje
        $query = "SELECT nazwa_uzytkownika FROM `konto`";
        $uzytkownicy = $connection->query($query);

        while ($wiersz = $uzytkownicy->fetch_assoc()) {
            if ($login === $wiersz['nazwa_uzytkownika']) {
                $istnieje = true;
                break;
            }
        }

        if ($istnieje) {
            //pobieranie hasla z bazy
            $query = "SELECT haslo FROM `konto` WHERE nazwa_uzytkownika='$login'";
            $result = $connection->query($query);
            $wiersz = $result->fetch_assoc();
            $haslo_baza_danych = $wiersz['haslo'];

            //sprawdzenie zgosnosci z haslem i wpisywanie danych do sesji
            if ($haslo === $haslo_baza_danych) {
                $_SESSION['nazwa_uzytkownika'] = $login;
                $query = "SELECT admin FROM `konto` WHERE nazwa_uzytkownika='$login'";
                $wynik = $connection->query($query);
                $wiersz = $wynik->fetch_assoc();

                $_SESSION['czy_admin'] = ($wiersz['admin'] == 1);
                header("Location: ../zalogowany/zalogowany-index.php"); //przekierowanie do innego pliku
    
                //w nastepnych elsa'ach to wyswietlanie bledow jelsi cos pojdzie nie tak
            } else {
                errorBlock("Haslo jest nie poprawne", "login.php");
            }
        } else {
            errorBlock("Uzytkownik nie istnieje - Kliknij 'Nie mam konta'", "login.php");
        }
    } else if ((empty($_POST['login']) || empty($_POST['haslo'])) && isset($_POST['submit'])) {
        errorBlock("Pola musza byc wypelnione", "login.php");
    }

    $connection->close();
    ?>
</body>

</html>
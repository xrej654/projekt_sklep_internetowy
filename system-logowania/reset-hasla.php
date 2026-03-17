<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
    <link rel="stylesheet" href="../style/style-reset-hasla.css">
</head>

<body>
    <?php
    include("../config/config.php");

    session_start();

    echo "<section class=\"reset-hasla\">";
    if (isset($_POST['submit']) && isset($_POST['email'])) {
        echo "[To haslo bylo by na mailu] <br>";
        $noweHaslo = "";
        $email = htmlspecialchars($_POST['email']);

        $nazwa_uzytkownika = $connection->query("SELECT nazwa_uzytkownika FROM konto WHERE email = '{$email}'")->fetch_assoc()['nazwa_uzytkownika'];

        while (strlen($noweHaslo) <= 8) {
            $znak = chr(rand(33, 125));
            $noweHaslo .= $znak;
        }

        $noweHaslo = htmlspecialchars($noweHaslo);

        echo $noweHaslo;

        $connection->query("UPDATE `konto` SET haslo = '{$noweHaslo}' WHERE nazwa_uzytkownika='{$nazwa_uzytkownika}'");

        echo "<br> <a href=\"login.php\">Wroc do logowania (nie zapomnij o nowym hasle i polecamy zmienic odrazu po zalogowaniu)</a>";
    } else {
        echo "<form method=\"post\">";
        echo "<input type=\"email\" name=\"email\" placeholder=\"Podaj mail na ktory wyslac nowe haslo\"> <br> <button type=\"submit\" name=\"submit\">Wyslij</button>";
        echo "</form>";
    }
    echo "</section>";
    ?>
</body>

</html>
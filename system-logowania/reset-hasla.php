<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="stylesheet" href="../style/style-wspolne-formularze.css">
</head>

<body>
    <?php
    include("../config/config.php");

    session_satrt();



    if (isset($_POST['submit'])) {
        echo "[To haslo bylo by na mailu]";
        $noweHaslo = "";

        while (strlen($noweHaslo) <= 8) {
            $noweHaslo += chr(rand(33, 125));
        }

        echo $noweHaslo;

        $connection->query("UPDATE `konto` SET haslo = '{$noweHaslo}' WHERE id = {$_GET['id']}");
    } else {
        echo "<form method=\"post\">";
        echo "<input type=\"email\" placeholder=\"Podaj mail na ktory wyslac nowe haslo\"> <br> <button type=\"submit\" name=\"submit\">Wyslij</button>";
        echo "</form>";
    }
    ?>
</body>

</html>

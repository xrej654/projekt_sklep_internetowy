<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="../style/style-globalne.css">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style-tabelka-panelu.css">
</head>

<body>
    <section class="tabelka-panelu">
        <a href="panel-admina.php">Anuluj</a>
        <a href="kategorie.php?czy_dodac=true">Dodaj</a>
        <?php
        include("../config/config.php");

        error_reporting(E_ALL & ~E_WARNING);

        //kod z header najlepej napisac na poczatku aby nie bylo bledu
        //kod obowiazuje kolejno za dodawanie, zmiana i usuwanie rekordow do bazy
        if (isset($_POST["submit"])) {
            if (empty($_POST["nazwa_kategorii"]) && empty($_POST['ikona'])) {
                errorBlock("Prosze wypelnic pole", "kategorie.php");
            } else {
                $nazwaKategorii = htmlspecialchars($_POST['nazwa_kategorii']);
                $ikona = htmlspecialchars($_POST['ikona']);

                $query = "INSERT INTO `kategoria` (kategoria, ikona) VALUES ('{$nazwaKategorii}', '{$ikona}')";
                $connection->query($query);

                header("Location: kategorie.php");
            }
        }

        if (isset($_POST["zmien"]) && !empty($_POST['kategoria']) && !empty($_POST["nowa_nazwa_kategorii"]) && !empty($_POST['nowa_ikona'])) {
            $kategoria = htmlspecialchars($_POST['kategoria']);
            $nowaNazwaKategorii = htmlspecialchars($_POST['nowa_nazwa_kategorii']);
            $nowa_ikona = htmlspecialchars($_POST['nowa_ikona']);

            $query = "UPDATE `kategoria` SET kategoria='{$nowaNazwaKategorii}', ikona='{$nowa_ikona}' WHERE kategoria = '{$kategoria}'";
            $connection->query($query);

            header("Location: kategorie.php");
        } else if (isset($_POST['submit']) && empty($_POST["nowa_nazwa_kategorii"]) && empty($_POST['nowa_ikona'])) {
            errorBlock("Prosze uzupelnic pole", "kategorie.php");
        }

        if (isset($_POST["usun"]) && !empty($_POST['kategoria'])) {
            $kategoria = htmlspecialchars($_POST['kategoria']);

            $query = "DELETE FROM `kategoria` WHERE kategoria='{$kategoria}'";
            $connection->query($query);

            header("Location: kategorie.php");
        }

        $query = "SELECT DISTINCT *  FROM `kategoria`";
        $result = $connection->query($query);

        echo "<table> <tr> <th>Kategoria</th> <th>Link do ikony</th> <th>Zmien</th> <th>Usun</th> </tr>";

        //wyswietlnaie produktow
        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\"";
            echo "<tr>";

            $kategoria = htmlspecialchars($row['kategoria']);
            $ikonaBaza = htmlspecialchars($row['ikona']);

            if ($kategoria == $_POST['kategoria'] && isset($_POST['zmien-formularz'])) { //formualrz na zmiane rekodrow w bazie
                echo "<td> <input name=\"nowa_nazwa_kategorii\" value=\"{$kategoria}\"> </td>";
                echo "<td> <select name=\"nowa_ikona\">";
                echo "<option selected>{$ikonaBaza}</option>";

                $linkiDoIkon = glob("../assets/Icons/*");

                foreach ($linkiDoIkon as $ikona) {
                    echo "<option>{$ikona}</opiton>";
                }

                echo "</select> </td>";
                echo "<input type=\"hidden\" name=\"kategoria\" value=\"{$kategoria}\">";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"zmien\">Zmien</button> </td>";
            } else {
                echo "<td>" . $kategoria . "</td>";
                echo "<td>" . $ikonaBaza . "</td>";

                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true) {
                    echo "<td> <button type=\"submit\" name=\"zmien-formularz\">Zmien</button> </td>";
                    echo "<td> <button type=\"submit\" name=\"usun\">Usun</button> </td>";
                } else
                    echo "<td colspan=\"2\" style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            }

            echo "<input type=\"hidden\" name=\"kategoria\" value=\"{$kategoria}\">";
            echo "</tr>";
            echo "</form>";
        }

        //formualrz na dodawanie nowych rekordow
        if (isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] == true) {
            echo "<form method=\"post\"";
            echo "<tr>";
            echo "<td> <input name=\"nazwa_kategorii\"> </td>";

            echo "<td> <select name=\"ikona\">";
            echo "<option selected></option>";

            $linkiDoIkon = glob("../assets/Icons/*");

            foreach ($linkiDoIkon as $ikona) {
                echo "<option>{$ikona}</opiton>";
            }

            echo "</select> </td>";

            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</tr>";
            echo "</form>";
        }

        echo "</table>";
        ?>
    </section>
</body>

</html>
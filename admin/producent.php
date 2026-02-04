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
        <a href="producent.php?czy_dodac=true">Dodaj</a>
        <?php
        include("../config/config.php");

        error_reporting(E_ALL & ~E_WARNING);

        //kod z header najlepiej na poczatku aby nie bylo bledow
        //kolejno warunek na dodawanie nowych rekordow, zmiane istniejacych i usuwanie
        if (isset($_POST["submit"])) {
            if (empty($_POST["nazwa_producenta"])) {
                errorBlock("Prosze wypelnic pole", "producent.php");
            } else {
                $query = "INSERT INTO `producent` (producent) VALUES ('{$_POST['nazwa_producenta']}')";
                $connection->query($query);
                header("Location: producent.php");
            }
        }

        if (isset($_POST["zmien"]) && !empty($_POST['producent']) && !empty($_POST["nowa_nazwa_producenta"])) {
            $query = "UPDATE `producent` SET producent='{$_POST['nowa_nazwa_producenta']}' WHERE producent = '{$_POST['producent']}'";
            $connection->query($query);

            header("Location: producent.php");
        } else if (isset($_POST['submit']) && empty($_POST["nowa_nazwa_producenta"])) {
            errorBlock("Prosze uzupelnic pole", "producent.php");
        }

        if (isset($_POST["usun"]) && !empty($_POST['producent'])) {
            $query = "DELETE FROM `producent` WHERE producent='{$_POST['producent']}'";
            $connection->query($query);

            header("Location: producent.php");
        }
        
        $query = "SELECT DISTINCT *  FROM `producent`";
        $result = $connection->query($query);

        echo "<table> <tr> <th>producent</th> <th>Zmien</th> <th>Usun</th> </tr>";

        //wyswietlanie rekorodw z bazy
        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\"";
            echo "<tr>";

            $producent = htmlspecialchars($row['producent']);

            if ($producent == $_POST['producent'] && isset($_POST['zmien-formularz'])) { //formularz na zmiane nazwy producenta
                echo "<td> <input name=\"nowa_nazwa_producenta\" value=\"{$_POST['producent']}\"> </td>";
                echo "<input type=\"hidden\" name=\"producent\" value=\"{$_POST['producent']}\">";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"zmien\">Zmien</button> </td>";
            } else {
                echo "<td>" . $producent . "</td>";

                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true) {
                    echo "<td> <button type=\"submit\" name=\"zmien-formularz\">Zmien</button> </td>";
                    echo "<td> <button type=\"submit\" name=\"usun\">Usun</button> </td>";
                } else
                    echo "<td colspan=\"2\" style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            }

            echo "<input type=\"hidden\" name=\"producent\" value=\"{$producent}\">";
            echo "</tr>";
            echo "</form>";
        }

        //kod na formularz na dodanie nowego producenta
        if (isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] == true) {
            echo "<form method=\"post\"";
            echo "<tr>";
            echo "<td> <input name=\"nazwa_producenta\"> </td>";
            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</tr>";
            echo "</form>";
        }

        echo "</table>";
        ?>
    </section>
</body>

</html>
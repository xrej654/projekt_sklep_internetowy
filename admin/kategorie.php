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

        $query = "SELECT DISTINCT *  FROM `kategoria`";
        $result = $connection->query($query);

        echo "<table> <tr> <th>Kategoria</th> <th>Zmien</th> <th>Usun</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\"";
            echo "<tr>";
            if ($row['kategoria'] == $_POST['kategoria'] && isset($_POST['zmien-formularz'])) {
                $kategoria = htmlspecialchars($_POST['kategoria']);
                echo "<td> <input name=\"nowa_nazwa_kategorii\" value=\"{$kategoria}\"> </td>";
                echo "<input type=\"hidden\" name=\"kategoria\" value=\"{$kategoria}\">";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"zmien\">Zmien</button> </td>";
            } else {
                echo "<td>" . $row['kategoria'] . "</td>";
                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true)
                    echo "<td> <button type=\"submit\" name=\"zmien-formularz\">Zmien</button> </td>";
                else
                    echo "<td style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true)
                    echo "<td> <button type=\"submit\" name=\"usun\">Usun</button> </td>";
                else
                    echo "<td style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            }
            echo "<input type=\"hidden\" name=\"kategoria\" value=\"{$row['kategoria']}\">";
            echo "</tr>";
            echo "</form>";
        }

        if (isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] == true) {
            echo "<form method=\"post\"";
            echo "<tr>";
            echo "<td> <input name=\"nazwa_kategorii\"> </td>";
            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";

        if (isset($_POST["submit"])) {
            if (empty($_POST["nazwa_kategorii"])) {
                errorBlock("Prosze wypelnic pole", "kategorie.php");
            } else {
                $nazwaKategorii = htmlspecialchars($_POST['nazwa_kategorii']);
                $query = "INSERT INTO `kategoria` (kategoria) VALUES ('{$nazwaKategorii}')";
                $connection->query($query);
                header("Location: kategorie.php");
            }
        }

        if (isset($_POST["zmien"]) && !empty($_POST['kategoria']) && !empty($_POST["nowa_nazwa_kategorii"])) {
            $kategoria = htmlspecialchars($_POST['kategoria']);
            $nowaNazwaKategorii = htmlspecialchars($_POST['nowa_nazwa_kategorii']);
            $query = "UPDATE `kategoria` SET kategoria='{nowaNazwaKategorii}' WHERE kategoria = '{$kategoria}'";
            $connection->query($query);
            header("Location: kategorie.php");
        } else if (!empty($_POST["nowa_nazwa_kategorii"])) {
            errorBlock("Prosze uzupelnic pole", "kategorie.php");
        }

        if (isset($_POST["usun"]) && !empty($_POST['kategoria'])) {
            $kategoria = htmlspecialchars($_POST['kategoria']);
            $query = "DELETE FROM `kategoria` WHERE kategoria='{$kategoria}'";
            $connection->query($query);
            header("Location: kategorie.php");
        }
        ?>
    </section>
</body>

</html>
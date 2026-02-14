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
        <a href="promocje.php?czy_dodac=true">Dodaj</a>

        <?php
        include("../config/config.php");

        //warunki z header najlepiej dac na poczatku z powodu mozliwych bledow
        //kod wykonujacy zmiane danych
        if (isset($_POST["zmiana"]) && !empty($_POST['nowa_nazwa_promocjii'])) {
            $nowaNazwaPromocji = htmlspecialchars($_POST['nowa_nazwa_promocjii']);
            $nowaObnizkaCeny = htmlspecialchars($_POST['nowa_obnizka_ceny']);

            $query = "UPDATE `promocja` SET promocja = '{$nowaNazwaPromocji}', obnizka_ceny = '{$nowaObnizkaCeny}' WHERE promocja_id = {$_POST['id']}";
            $connection->query($query);

            header("Location: promocje.php");
        } else if (empty($_POST['nowa_nazwa_promocjii']) && isset($_POST['submit'])) {
            blokBledu("Prosze uzupelnic pole", "promocje.php", "../assets/x.png");
        }

        //kod na usuwanie danych
        if (isset($_POST["usun"])) {
            $query = "DELETE FROM `promocja` WHERE promocja_id = {$_POST['id']}";
            $connection->query($query);

            header("Location: promocje.php");
        }

        //kod na dodawanie danych
        if (isset($_POST['submit']) && !empty($_POST['nazwa_promocji'])) {
            $nazwaPromocji = htmlspecialchars($_POST['nazwa_promocji']);
            $obnizkaCeny = htmlspecialchars($_POST['obnizka_ceny']);

            $query = "INSERT INTO `promocja` (promocja, obnizka_ceny) VALUES ('{$nazwaPromocji}', '{$obnizkaCeny}')";
            $connection->query($query);

            header("Location: promocje.php");
        } else if (empty($_POST['nazwa_promocji']) && isset($_POST['submit'])) {
            blokBledu("Prosze uzupelnic pole", "promocje.php", "../assets/x.png");
        }

        $query = "SELECT * FROM `promocja`";
        $result = $connection->query($query);

        //wyswietlanie tabeli produktow
        echo "<table> <tr> <th>Promocja</th> <th>Obnizka</th> <th>Zmien</th> <th>Usun</th> </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\">";

            if (isset($_POST['id']) && $row['promocja_id'] == $_POST['id']) //kod na zmiane danych w tabeli
            {
                echo "<tr> <td><input name=\"nowa_nazwa_promocjii\" value=\"{$row['promocja']}\"}></td>";
                echo "<td><input name=\"nowa_obnizka_ceny\" value=\"{$row['obnizka_ceny']}\"}></td> <td colspan=\"2\"><button type=\"submit\" name=\"zmiana\">Zmien</button></td> </tr>";
            } else {
                echo "<tr> <td>{$row['promocja']}</td>";
                echo "<td>{$row['obnizka_ceny']}%</td>";

                if (isset($_POST['czy_dodac']) || isset($_POST['id']))
                    echo "<td colspan=\"2\">Dostepne jak zakonczysz formualrz dodawania</tr>";
                else
                    echo "<td><button type=\"submit\" name=\"zmien\">Zmien</button></td> <td><button type=\"submit\" name=\"usun\">Usun</button></td> </tr>";
            }

            echo "<input type=\"hidden\" name=\"id\" value=\"{$row['promocja_id']}\">";
            echo "</form>";
        }

        //kod na dodawanie nowego rekordu
        if (isset($_GET['czy_dodac'])) {
            echo "<form  method=\"post\">";
            echo "<tr>";
            echo "<td> <input name=\"nazwa_promocji\"> </td>";
            echo "<td> <input name=\"obnizka_ceny\"> </td>";
            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </section>
</body>

</html>
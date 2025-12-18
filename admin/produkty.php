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
        <a href="produkty.php?czy_dodac=true">Dodaj</a>
        <?php
        include("../config/config.php");

        error_reporting(E_ALL & ~E_WARNING);

        $query = "SELECT pc.producent_id AS producent_id, k.kategoria_id AS kategoria_id, pk.produkt_id AS produkt_id, pk.nazwa AS nazwa, k.kategoria AS kategoria, pk.cena AS cena, pk.fotografia AS fotografia, pc.producent AS producent, pk.opis AS opis, pk.ilosc AS ilosc FROM `produkt` pk JOIN `kategoria` k ON pk.kategoria_id = k.kategoria_id JOIN `producent` pc ON pk.producent_id = pc.producent_id";
        $result = $connection->query($query);

        echo "<table> <tr> <th>Nazwa</th> <th>Kategoria</th> <th>Cena</th> <th>Fotografia</th> <th>Producent</th> <th>Opis</th> <th>Ilosc</th> <th>Zmien</th> <th>Usun</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\">";
            if (isset($_POST["zmien-formularz"]) && $_POST["id"] == $row["produkt_id"]) {
                echo "<tr>";
                echo "<td> <input name=\"nazwa\" value=\"{$row["nazwa"]}\"> </td>";
                echo "<td> <select name=\"kategoria\">";

                echo "<option selected value='{$row["kategoria_id"]}'>{$row["kategoria"]}</option>";
                $query = "SELECT * FROM `kategoria`";
                $result = $connection->query($query);
                while ($rowTmp = $result->fetch_assoc()) {
                    if ($rowTmp["kategoria"] != $row["kategoria"])
                        echo "<option value='{$rowTmp["kategoria_id"]}'>{$rowTmp["kategoria"]}</option>";
                }

                echo "</select></td>";

                echo "<td> <input name=\"cena\" value=\"{$row["cena"]}\"> </td>";
                echo "<td> <input name=\"fotografia\" value=\"{$row["fotografia"]}\"> </td>";

                echo "<td> <select name=\"producent\">";
                echo "<option selected value='{$row['producent_id']}'>{$row["producent"]}</option>";
                $query = "SELECT * FROM `producent`";
                $result = $connection->query($query);
                while ($rowTmp = $result->fetch_assoc()) {
                    if ($rowTmp["producent"] != $row["producent"])
                        echo "<option value='{$rowTmp["producent_id"]}'>{$rowTmp["producent"]}</option>";
                }

                echo "</select></td>";
                echo "<td> <textarea name=\"opis\">{$row["opis"]}</textarea> </td>";
                echo "<td> <input name=\"ilosc\" value=\"{$row["ilosc"]}\"> </td>";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"zmiana\">Zmien</button> </td>";
            } else {
                echo "<tr>";
                echo "<td>" . $row['nazwa'] . "</td>";
                echo "<td>" . $row['kategoria'] . "</td>";
                echo "<td>" . $row['cena'] . "</td>";
                echo "<td>" . $row['fotografia'] . "</td>";
                echo "<td>" . $row['producent'] . "</td>";
                echo "<td style=\"width: 10vw;\">" . $row['opis'] . "</td>";
                echo "<td>" . $row['ilosc'] . "</td>";
                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true)
                    echo "<td> <button type=\"submit\" name=\"zmien-formularz\">Zmien</button> </td>";
                else
                    echo "<td style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true)
                    echo "<td> <button type=\"submit\" name=\"usun\">Usun</button> </td>";
                else
                    echo "<td style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            }

            echo "<input type=\"hidden\" name=\"id\" value=\"{$row["produkt_id"]}\"";
            echo "</tr>";
            echo "</form>";
        }

        if (isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] == true) {
            echo "<form method=\"post\">";
            echo "<tr>";
            echo "<td> <input name=\"nazwa_produktu\"> </td>";
            echo "<td> <select name=\"kategoria\">";

            $query = "SELECT * FROM `kategoria`";
            $result = $connection->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row["kategoria_id"]}'>{$row["kategoria"]}</option>";
            }

            echo "</select></td>";
            echo "<td> <input type=\"number\" name=\"cena\"> </td>";
            echo "<td> <input name=\"fotografia\"> </td>";
            echo "<td> <select name=\"producent\">";

            $query = "SELECT * FROM `producent`";
            $result = $connection->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row["producent_id"]}'>{$row["producent"]}</option>";
            }

            echo "</select></td>";
            echo "<td> <textarea name=\"opis\"></textarea> </td>";
            echo "<td> <input type=\"numbr\" name=\"ilosc\"> </td>";
            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</form>";
            echo "</tr>";
        }

        if (isset($_POST["submit"])) {
            $query = "INSERT INTO `produkt` 
            (nazwa, kategoria_id, cena, fotografia, producent_id, opis, ilosc) 
            VALUES 
            ('{$_POST["nazwa_produktu"]}','{$_POST["kategoria"]}','{$_POST["cena"]}','{$_POST["fotografia"]}'
            ,'{$_POST["producent"]}','{$_POST["opis"]}','{$_POST["ilosc"]}')";

            $connection->query($query);

            header("Location: produkty.php");
        }

        if (isset($_POST['zmiana'])) {
            $query = "UPDATE `produkt` 
            SET 
            nazwa='{$_POST['nazwa']}',
            kategoria_id='{$_POST['kategoria']}',
            cena={$_POST['cena']},
            fotografia='{$_POST['fotografia']}',
            producent_id='{$_POST['producent']}',
            opis='{$_POST['opis']}',
            ilosc={$_POST['ilosc']}
            WHERE produkt_id = '{$_POST['id']}'
            ";

            $connection->query($query);

            header("Location: produkty.php");
        }

        if (isset($_POST["usun"])) {
            $query = "DELETE FROM `produkt` WHERE produkt_id={$_POST["id"]}";
            $connection->query($query);

            header("Location: produkty.php");
        }

        echo "</table>";
        ?>
    </section>
</body>

</html>
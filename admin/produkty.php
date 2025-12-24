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

            $nazwa = htmlspecialchars($row['nazwa']);
            $kategoria = htmlspecialchars($row['kategoria']);
            $cena = htmlspecialchars($row['cena']);
            $fotografia = htmlspecialchars($row['fotografia']);
            $producent = htmlspecialchars($row['producent']);
            $opis = htmlspecialchars($row['opis']);
            $ilosc = htmlspecialchars($row['ilosc']);

            if (isset($_POST["zmien-formularz"]) && $_POST["id"] == $row["produkt_id"]) {
                echo "<tr>";
                echo "<td> <input name=\"nazwa\" value=\"{$nazwa}\"> </td>";
                echo "<td> <select name=\"kategoria\">";

                echo "<option selected value='{$row["kategoria_id"]}'>{$kategoria}</option>";

                $query = "SELECT * FROM `kategoria`";
                $result = $connection->query($query);

                while ($rowTmp = $result->fetch_assoc()) {
                    if ($rowTmp["kategoria"] != $kategoria) {
                        $inneKategorie = htmlspecialchars($rowTmp['kategoria']);
                        echo "<option value='{$rowTmp["kategoria_id"]}'>{$inneKategorie}</option>";
                    }
                }

                echo "</select></td>";

                echo "<td> <input name=\"cena\" value=\"{$cena}\"> </td>";
                echo "<td> <input name=\"fotografia\" value=\"{$fotografia}\"> </td>";

                echo "<td> <select name=\"producent\">";

                echo "<option selected value='{$row['producent_id']}'>{$producent}</option>";
                $query = "SELECT * FROM `producent`";
                $result = $connection->query($query);

                while ($rowTmp = $result->fetch_assoc()) {
                    if ($rowTmp["producent"] != $producent) {
                        $innyProducent = htmlspecialchars($rowTmp['producent']);
                        echo "<option value='{$rowTmp["producent_id"]}'>{$innyProducent}</option>";
                    }
                }

                echo "</select></td>";
                echo "<td> <textarea name=\"opis\">{$opis}</textarea> </td>";
                echo "<td> <input name=\"ilosc\" value=\"{$ilosc}\"> </td>";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"zmiana\">Zmien</button> </td>";
            } else {
                echo "<tr>";
                echo "<td>" . $nazwa . "</td>";
                echo "<td>" . $kategoria . "</td>";
                echo "<td>" . $cena . "</td>";
                echo "<td>" . $fotografia . "</td>";
                echo "<td>" . $producent . "</td>";
                echo "<td style=\"width: 10vw;\">" . $opis . "</td>";
                echo "<td>" . $ilosc . "</td>";

                if (!isset($_GET["czy_dodac"]) && $_GET["czy_dodac"] != true) {
                    echo "<td> <button type=\"submit\" name=\"zmien-formularz\">Zmien</button> </td>";
                    echo "<td> <button type=\"submit\" name=\"usun\">Usun</button> </td>";
                } else
                    echo "<td colspan=\"2\" style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
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
                $kategoria = htmlspecialchars($row['kategoria']);
                echo "<option value='{$row["kategoria_id"]}'>{$kategoria}</option>";
            }

            echo "</select></td>";
            echo "<td> <input type=\"number\" name=\"cena\"> </td>";
            echo "<td> <input name=\"fotografia\"> </td>";
            echo "<td> <select name=\"producent\">";

            $query = "SELECT * FROM `producent`";
            $result = $connection->query($query);

            while ($row = $result->fetch_assoc()) {
                $producent = htmlspecialchars($row["producent"]);
                echo "<option value='{$row["producent_id"]}'>{$producent}</option>";
            }

            echo "</select></td>";
            echo "<td> <textarea name=\"opis\"></textarea> </td>";
            echo "<td> <input type=\"numbr\" name=\"ilosc\"> </td>";
            echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
            echo "</form>";
            echo "</tr>";
        }

        if (
            isset($_POST["submit"]) &&
            !(empty($_POST['nazwa']) || empty($_POST['kategoria']) || empty($_POST['cena']) || empty($_POST['fotografia']) || empty($_POST['producent']) || empty($_POST['opis']) || empty($_POST['ilosc']))
        ) {
            $nazwa = htmlspecialchars($_POST['nazwa']);
            $kategoria = htmlspecialchars($_POST['kategoria']);
            $cena = htmlspecialchars($_POST['cena']);
            $fotografia = htmlspecialchars($_POST['fotografia']);
            $producent = htmlspecialchars($_POST['producent']);
            $opis = htmlspecialchars($_POST['opis']);
            $ilosc = htmlspecialchars($_POST['ilosc']);

            $query = "INSERT INTO `produkt` 
            (nazwa, kategoria_id, cena, fotografia, producent_id, opis, ilosc) 
            VALUES 
            ('{$nazwa_produktu}','{$kategoria}','{$cena}','{$fotografia}'
            ,'{$producent}','{$opis}','{$ilosc}')";

            $connection->query($query);

            header("Location: produkty.php");
        } else if (
            empty($_POST['nazwa']) || empty($_POST['kategoria']) || empty($_POST['cena']) || empty($_POST['fotografia']) || empty($_POST['producent']) || empty($_POST['opis']) || empty($_POST['ilosc'])
        ) {
            errorBlock("Prosze uzupelnic wszytkie pola", "produkty.php");
        }

        if (
            isset($_POST['zmiana']) &&
            !(empty($_POST['nazwa']) || empty($_POST['kategoria']) || empty($_POST['cena']) || empty($_POST['fotografia']) || empty($_POST['producent']) || empty($_POST['opis']) || empty($_POST['ilosc']))
        ) {
            $nazwa = htmlspecialchars($_POST['nazwa']);
            $kategoria = htmlspecialchars($_POST['kategoria']);
            $cena = htmlspecialchars($_POST['cena']);
            $fotografia = htmlspecialchars($_POST['fotografia']);
            $producent = htmlspecialchars($_POST['producent']);
            $opis = htmlspecialchars($_POST['opis']);
            $ilosc = htmlspecialchars($_POST['ilosc']);

            $query = "UPDATE `produkt` 
            SET 
            nazwa='{$nazwa}',
            kategoria_id='{$kategoria}',
            cena={$cena},
            fotografia='{$fotografia}',
            producent_id='{$producent}',
            opis='{$opis}',
            ilosc={$ilosc}
            WHERE produkt_id = '{$_POST['id']}'
            ";

            $connection->query($query);

            header("Location: produkty.php");
        } else if (
            empty($_POST['nazwa']) || empty($_POST['kategoria']) || empty($_POST['cena']) || empty($_POST['fotografia']) || empty($_POST['producent']) || empty($_POST['opis']) || empty($_POST['ilosc'])
        ) {
            errorBlock("Prosze uzupelnic wszytkie pola", "produkty.php");
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
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
        <a href="galeria-zdjec.php?czy_dodac=true">Dodaj</a>
        <?php
        include("../config/config.php");

        error_reporting(E_ALL & ~E_WARNING);

        $query = "SELECT * FROM `zdjecia` JOIN `produkt` USING(produkt_id)";
        $result = $connection->query($query);

        echo "<table>";
        echo "<tr> <th>Link zdjecia</th> <th>Produkt</th> <th>Zmien</th> <th>Usun</th>";
        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\">";
            echo "<tr>";
            if ($row['zdjecia_id'] == $_POST['id'] && isset($_POST['zmien'])) {
                echo "<td> <input name=\"link\" value=\"{$row['link']}\"> </td>";
                echo "<td>";

                $query = "SELECT * FROM `produkt`";
                $result = $connection->query($query);

                echo "<select name=\"produkt_id\"";
                echo "<option selected value=\"{$_POST['id']}\">{$row['nazwa']}</option>";
                while ($row = $result->fetch_assoc()) {
                    if ($row['produkt_id'] != $_POST['id'])
                        echo "<option value=\"{$row['produkt_id']}\">{$row['nazwa']}</option>";
                }

                echo "</td>";
            } else
                echo "<td> {$row['link']} </td> <td>{$row['nazwa']} </td>";

            if (isset($_GET['czy_dodac']) && $_GET['czy_dodac'] == true)
                echo "<td colspan=\"2\" style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            else
                echo "<td> <button name=\"zmien\">Zmien</button> </td> <td><button name=\"usun\">Usun</button> </td>";

            echo "<input type=\"hidden\" name=\"id\" value={$row['zdjecia_id']}>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";
        ?>
    </section>
</body>

</html>
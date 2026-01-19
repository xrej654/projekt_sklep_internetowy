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
                $linkiDoFotografii = glob("../assets/Product_images/*");
                echo "<td>";

                echo "<select name=\"fotografia\">";
                foreach ($linkiDoFotografii as $link) {
                    echo "<option>{$link}</option>";
                }
                echo "</select>";

                echo "</td>";

                echo "<td>";

                $query = "SELECT * FROM `produkt`";
                $productResult = $connection->query($query);

                echo "<select name=\"produkt_id\"";
                echo "<option selected value=\"{$_POST['id']}\">{$row['nazwa']}</option>";
                while ($productRow = $productResult->fetch_assoc()) {
                    if ($productRow['produkt_id'] != $_POST['id'])
                        echo "<option value=\"{$productRow['produkt_id']}\">{$productRow['nazwa']}</option>";
                }

                echo "</td>";
            } else
                echo "<td> {$row['link']} </td> <td>{$row['nazwa']} </td>";

            if (isset($_GET['czy_dodac']) && $_GET['czy_dodac'] == true)
                echo "<td colspan=\"2\" style=\"width:12.5vw;\">Dostepne jak zakonczysz formualrz dodawania</td>";
            else
                if ($row['zdjecia_id'] == $_POST['id'] && isset($_POST['zmien'])) {
                    echo "<td colspan=\"2\"> <button name=\"zmiana\">Zmien</button></td>";
                } else {
                    echo "<td> <button name=\"zmien\">Zmien</button> </td> <td><button name=\"usun\">Usun</button> </td>";
                }

            echo "<input type=\"hidden\" name=\"id\" value={$row['zdjecia_id']}>";
            echo "</tr>";
            echo "</form>";
        }

        if (isset($_GET['czy_dodac']) && $_GET['czy_dodac'] == true) {
            echo "<form method=\"post\"";
            echo "<tr>";

            $linkiDoFotografii = glob("../assets/Product_images/*");
            echo "<td>";

            echo "<select name=\"fotografia\">";
            foreach ($linkiDoFotografii as $link) {
                echo "<option>{$link}</option>";
            }
            echo "</select>";
            echo "</td>";

            echo "<td>";

            $query = "SELECT * FROM `produkt`";
            $productResult = $connection->query($query);

            echo "<select name=\"produkt_id\"";
            echo "<option selected value=\"{$_POST['id']}\">{$row['nazwa']}</option>";
            while ($productRow = $productResult->fetch_assoc()) {
                if ($productRow['produkt_id'] != $_POST['id'])
                    echo "<option value=\"{$productRow['produkt_id']}\">{$productRow['nazwa']}</option>";
            }

            echo "</td>";

            echo "<td colspan=\"2\"> <button name=\"dodaj\" type=\"submit\">Dodaj</button></td>";
            echo "</tr>";
            echo "<form>";
        }

        if (isset($_POST['zmiana'])) {
            if (isset($_POST['fotografia']) && isset($_POST['product_id'])) {
                $query = "UPDATE `zdjecia` SET link={$_POST['fotografia']}, product_id={$_POST['product_id']}";
                $connection->query($query);

                header("Location: galeria-zdjec.php");
            } else {
                errorBlock("Prosze uzupelnic pola", "galeria-zdjec.php");
            }
        }

        if (isset($_POST['dodaj']))
        {
            $query = "INSERT INTO `zdjecia` (link, produkt_id) VALUES ('{$_POST['fotografia']}', '{$_POST['produkt_id']}')";
            $connection->query($query);

            header("Location: galeria-zdjec.php");
        }

        if (isset($_POST['usun'])) {
            $query = "DELETE FROM `zdjecia` WHERE zdjecia_id={$_POST['id']}";
            $connection->query($query);

            header("Location: galeria-zdjec.php");
        }

        echo "</table>";
        ?>
    </section>
</body>

</html>
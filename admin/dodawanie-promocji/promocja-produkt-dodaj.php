<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="../../style/style-globalne.css">
    <link rel="shortcut icon" href="../../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style/style-tabelka-panelu.css">
</head>

<body>
    <section class="tabelka-panelu">
        <a href="../sposob-dodania-promocji.php">Anuluj</a>
        <a href="">Dodaj</a>
        <?php
        include("../../config/config.php");

        error_reporting(E_ALL & ~E_WARNING);

        $query = "SELECT * FROM `produkt`";
        $result = $connection->query($query);

        echo "<form method=\"post\">";
        echo "<table>";
        echo "<tr> <th>Produkt</th> <th>Czy dodac promocje</th> <tr>";

        //wyswietlanie produktow
        while ($row = $result->fetch_assoc()) {
            $nazwa = htmlspecialchars($row['nazwa']);
            echo "<tr> <td style=\"padding:10px;\">{$nazwa}</td> <td><input type=\"checkbox\" name=\"ids[]\" value=\"{$row['produkt_id']}\"></td> </tr>";
        }
        echo "</table>";

        $query = "SELECT * FROM `promocja`";
        $result = $connection->query($query);

        echo "<select style=\"margin-left:4.5vw;\" name=\"promocja\">";

        //wyswietlanie promocji
        while ($row = $result->fetch_assoc()) {
            $nazwa = htmlspecialchars($row['promocja']);
            echo "<option value=\"{$row['promocja_id']}\">{$nazwa}</option>";
        }

        echo "</select>";

        echo "<button style=\"margin-left:0.5vw;\" type=\"submit\" name=\"submit\">Dodaj promocje</button>";
        echo "</form>";

        //dodawanie promocji wzgledem produktu
        if (isset($_POST['submit'])) {
            foreach ($_POST['ids'] as $id) {
                $query = "SELECT * FROM `promocja_produkt` WHERE promocja_id = {$_POST['promocja']} AND produkt_id = {$id}";
                $relations = $connection->query($query);       

                if ($relations->num_rows == 0) {
                    $query = "INSERT INTO `promocja_produkt` (promocja_id, produkt_id) VALUES ({$_POST['promocja']}, {$id})";
                    $connection->query($query);
                }
            }
        }

        ?>
    </section>
</body>

</html>
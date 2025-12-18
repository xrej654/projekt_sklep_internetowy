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

        $query = "SELECT * FROM `promocja`";
        $result = $connection->query($query);

        echo "<table> <tr> <th>Promocja</th> <th>Zmien</th> <th>Usun</th> </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<form method=\"post\">";
            if (isset($_POST['id']) && $row['promocja_id'] == $_POST['id'])
                echo "<tr> <td><input name=\"nowa_nazwa_promocjii\" value=\"{$row['promocja']}\"}></td> <td colspan=\"2\"><button type=\"submit\" name=\"zmiana\">Zmien</button></td> </tr>";
            else
                echo "<tr> <td>{$row['promocja']}</td>";
            if (isset($_POST['czy_dodac']))
                echo "<td>Dostepne jak zakonczysz formualrz dodawania</td> <td>PDostepne jak zakonczysz formualrz dodawania</td> </tr>";
            else
                echo "<td><button type=\"submit\" name=\"zmien\">Zmien</button></td> <td><button type=\"submit\" name=\"usun\">Usun</button></td> </tr>";

            if (isset($_GET['czy_dodac'])) {
                echo "<form  method=\"post\">";
                echo "<tr>";
                echo "<td> <input name=\"nazwa_promocji\"> </td>";
                echo "<td colspan=\"2\"> <button type=\"submit\" name=\"submit\">Dodaj</button> </td>";
                echo "</tr>";
                echo "</form>";
            }

            echo "<input type=\"hidden\" name=\"id\" value=\"{$row['promocja_id']}\">";
            echo "</form>";
        }

        if (isset($_POST["zmiana"])) {
            $query = "UPDATE `promocja` SET promocja = '{$_POST['nowa_nazwa_promocjii']}' WHERE promocja_id = {$_POST['id']}";
            $connection->query($query);
            header("Location: promocje.php");
        }

        if (isset($_POST["usun"])) {
            $query = "DELETE FROM `promocja` WHERE promocja_id = {$_POST['id']}";
            $connection->query($query);

            header("Location: promocje.php");
        }

        if (isset($_POST['submit']))
        {
            $query = "INSERT INTO `promocja` (promocja) VALUES ('{$_POST['nazwa_promocji']}')";
            $connection->query($query);

            header("Location: promocje.php");
        }
        ?>
    </section>
</body>

</html>
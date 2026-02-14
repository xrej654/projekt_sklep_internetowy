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

        <?php
        include("../config/config.php");

        session_start();

        $zamowienia = $connection->query("SELECT * FROM `zamowienie`");

        if (isset($_POST['ustaw']) && isset($_POST['status'])) {
            $connection->query("UPDATE `zamowienie` SET status = '{$_POST['status']}' WHERE zamowienie_id = {$_POST['id']}");
            header("Location: status-zamowien.php");
        }

        echo "<table>";
        echo "<th>Zamowienie id</th> <th>Nie wyslano</th> <th>W drodze</th> <th>Dostarczono</th> <th>Ustaw</th>";
        while ($zamowienie = $zamowienia->fetch_assoc()) {
            echo "<form method=\"post\"><tr>";
            echo "<td>{$zamowienie['zamowienie_id']} </td>";

            if ($zamowienie['status'] == "nie wyslano") {
                echo "<td><input type=\"radio\" name=\"status\" value=\"nie wyslano\" checked></td> <td><input type=\"radio\" name=\"status\" value=\"w drodze\"></td> <td><input type=\"radio\" name=\"status\" value=\"dostarczono\"></td>";
            } else if ($zamowienie['status'] == "w drodze") {
                echo "<td><input type=\"radio\" name=\"status\" value=\"nie wyslano\"></td> <td><input type=\"radio\" name=\"status\" value=\"w drodze\" checked></td> <td><input type=\"radio\" name=\"status\" value=\"dostarczono\"></td>";
            } else if ($zamowienie['status'] == "dostarczono") {
                echo "<td><input type=\"radio\" name=\"status\" value=\"nie wyslano\"></td> <td><input type=\"radio\" name=\"status\" value=\"w drodze\"></td> <td><input type=\"radio\" name=\"status\" value=\"dostarczono\" checked></td>";
            }

            echo "<td><button type=\"submit\" name=\"ustaw\">Ustaw</button></td>";
            echo "<input type=\"hidden\" name=\"id\" value=\"{$zamowienie['zamowienie_id']}\"> </tr></form>";
        }

        echo "</table>";
        ?>
    </section>
</body>

</html>
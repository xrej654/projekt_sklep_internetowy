<?php
//funkcja wyswietlajaca wiadomosc bledu
function blokBledu($wiadomosc, $link)
{
    echo <<<BLOKBLEDU
                        <form action="{$link}">
                            <div class="error-block">
                                <button type="submit">
                                    <img src="../assets/x.png">
                                </button>
                                <p>
                                    {$wiadomosc}
                                </p>
                            </div>
                        </form>
            BLOKBLEDU;
}

//zapis danych do polaczenie z baza i polaczenie z baza
$host = "localhost";
$user = "root";
$password = "";
$database = "sklep internetowy";

$connection = new mysqli($host, $user, $password, $database);

//sprawdzenie czy polaczenie sie udalo
if ($connection->connect_error) {
    die("Błąd połączenia: " . $connection->connect_error);
}
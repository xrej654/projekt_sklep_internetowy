<?php
function errorBlock($wiadomosc, $link)
{
    echo <<<ERRORBLOCK
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
            ERRORBLOCK;
}

$host = "localhost";
$user = "root";
$password = "";
$database = "sklep internetowy";

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Błąd połączenia: " . $connection->connect_error);
}
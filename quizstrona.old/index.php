<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./styles.css?<?php echo time(); ?>" />
        <title>Matematyczny quiz - old</title>
    </head>
    <body>
        <h1>Witaj na matematycznym quizie!</h1>
        <p>Aby rozpocząć quiz, proszę wprowadzić swój nick</p>
        <form action="quiz.php" method="post">
            <input type="text" name="nickname" placeholder="Prowadź swój nick" required>
            <input type="submit" value="Rozpocznij">
        </form>

        <?php
        
            $database = "baza_danych_quiz";
            $username = "root";
            $password = "";
            $host = "localhost";

            $answers = "";

            $connection = new mysqli($host, $username, $password, $database);

            if ($connection->connect_error)
            {
                die("Nie można połączyć się z serwerem!");
            }

            if (isset($_POST["nickname"]))
            {
                $nick = $_POST["nickname"];

                $query = "SELECT COUNT(*)FROM uzytkownicy WHERE nick = \"" . $nick . "\";";

                $result = $connection->query($query);

                $x = $result->fetch_assoc();

                if ($x["ilosc"] > 0)
                {
                    $nick = $nick . rand(0, 8421004);
                }

                $query = "INSERT INTO uzytkownicy VALUES (null, '$nick', 0);";

                if ($connection->query($query) === true)
                {
                    $_SESSION["nickname"] = $nick;
                } else {
                    echo "Wystąpił błąd z dodawaniem użytkownika do bazy...";
                }
            }
           $connection->close();
        ?>
    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./styles.css?<?php echo time(); ?>" type="text/css">
        <title>Matematyczny quiz - old - wyniki</title>
    </head>
    <body>
        <?php
            include "index.php";
            include "quiz.php";
        ?>
        <style>
            #wrap
            {
                display: relative;

                width: 65%;
                padding: 1%;

                overflow: hidden;
            }

            #tabela
            {
                background-color: white;

                border: 1px solid gray;
                border-radius: 3px;

                width: 25%;
                text-align: center;
            }


        </style>
        <div class="container">
        <?php 

            $database = "baza_danych_quiz";
            $username = "root";
            $password = "";
            $host = "localhost";

            $connection = new mysqli($host, $username, $password, $database);

            if ($connection->connect_error)
            {
                die("Nastąpiły problemy z połączeniem się z serwerem!");
            }
            echo "<div id=\"wrap\" style=\"padding-top: 1%;background-color: #ebebeb; border: 1px solid #d6d6d6; border-radius: 15px;\">";
            echo "<h1>Wyniki quizu</h1>";
            echo "<h4>Tabela wyników</h4>";
            echo "<div id=\"tabela\">";
            echo "<table border=\"1\" style=\"width: 100%;\">";
            echo "<thead>\n<tr>";
            echo    "<th>Nick</th><th>Zdobyte punkty</th>";
            echo "</tr>\n</thead>\n<tbody style=\"background-color: rgb(221, 221, 221);\">";

            if (isset($_SESSION["points"]) && isset($_SESSION["nickname"]))
            {
                $query = "UPDATE uzytkownicy SET punkty = " . $_SESSION["points"] . " WHERE nick = \"" . $_SESSION["nickname"] . "\";";

                $result = $connection->query($query);

                $query = "SELECT iduzytkownika from uzytkownicy WHERE nick = \"" . $_SESSION["nickname"] . "\";";

                $temp = $connection->query($query);

                $id = mysqli_fetch_array($temp);

                $query = "INSERT INTO tabela_wynikow VALUES (null, " . $id["iduzytkownika"] . ");";

                $result = $connection->query($query);
            }

            $query = "SELECT uzytkownicy.nick as \"nick\", uzytkownicy.punkty as \"punkty\" FROM tabela_wynikow, uzytkownicy WHERE tabela_wynikow.uzytkownik = uzytkownicy.iduzytkownika ORDER BY uzytkownicy.punkty DESC LIMIT 10;";

            $content = $connection->query($query);

            if ($content->num_rows > 0)
            {
                while ($place = $content->fetch_assoc())
                {
                    echo "<tr>";
                    echo "\t\t<td>" . $place["nick"] . "</td><td>" . $place["punkty"] . "</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";

            if (isset($_SESSION["points"]) && isset($_SESSION["nickname"]))
            {
                echo "Ilość zdobytych punktów: <strong>" . $_SESSION["points"] . "</strong><br>";
                echo "Twój nick: <strong>" . $_SESSION["nickname"] . "</strong><br>";
            } else {
                echo "Nastąpiły problemy z załadowaniem danych z sesji...<br><p style=\"font-size: 12px; color: gray\">Prawdopodobnie sesja została <span style=\"color: red;\">zniszczona</span> lub dane już <span style=\"color: red;\">nie istnieją</span>...</p>";
            }

            echo "</div>";

            session_unset();
            session_destroy();
            $connection->close();

        ?>
        </div>
    </body>
</html>
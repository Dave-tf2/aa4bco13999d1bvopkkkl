<!DOCTYPE html>
<html>
    <head>
        <title>Matematyczny quiz - old</title>
    </head>
    <body>
        <?php
            require "index.php";
            ob_end_clean();
        ?>
        <style>
        body
        {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }



        input[type=submit], input[type=text]
        {
            padding: 5px;
            font-size: 14px;
        }

        input[type=text]
        {
            padding: 15px;

            border: 1px dotted #d6d6d6;
            border-radius: 15px;
        }

        input[type=submit]
        {
            padding: 15px;
            margin: 20px;
            width: 100%;
        }


        #pytanie
        {
            display: flex;

            flex-direction: column;

            background-color: #ebebeb;

            margin: 5px;

            padding: 15px;

            border: 1px solid #d6d6d6;
            border-radius: 15px;

            width: 500px;
            height: 125px;

        }

        </style>
        <form action="results.php" method="post" style="margin: 5px; float: left;">
        <?php 
            

            $database = "baza_danych_quiz";
            $username = "root";
            $password = "";
            $host = "localhost";

            $pos = 0;

            $points = 0;

            $connection = new mysqli($host, $username, $password, $database);

            if ($connection->connect_error)
            {
                die("Nie można połączyć się z serwerem!");
            }
            $query = "SELECT idpytania as \"numer_pytania\", pytanie as \"tresc_pytania\" FROM pytania;";

            $content = $connection->query($query);

            if ($content->num_rows > 0)
            {
                while ($row = $content->fetch_assoc())
                {
                    echo "\t<div id=\"pytanie\">";
                    echo "\t\t<h2>" . $row["numer_pytania"] . ". " . $row["tresc_pytania"] . "</h2>";
                    echo "\t\t<input type=\"text\" name=\"answer[]\" placeholder=\"Wprowadź tutaj odpowiedź...\" required>";
                    echo "\t</div>";
                }
            }

            if (isset($_POST["answer"]))
            {
                

                $answers = $_POST["answer"];

                $query = "SELECT p_odp from pytania;";

                $content = $connection->query($query);

                if ($content->num_rows > 0)
                {
                    while ($row = $content->fetch_assoc())
                    {
                        if ($answers[$pos] == $row["p_odp"])
                        {
                            $points = $points + 1;
                        }
                        $pos++;
                    }
                }

            }
            $_SESSION["points"] = $points;
            

            $connection->close();
        ?>
        <input type="submit" value="Przeslij">
        </form>
    </body>
</html>
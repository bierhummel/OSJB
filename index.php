<?php

ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();
?>

<!DOCTYPE html>
<html lang="de">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="bilder/favicon-16x16.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <title>OSJB - Startseite</title>
</head>

<body class="background_index">
    
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>

    <div class="container border">
        <section>
            <h3 class="center">Finde jetzt den passenden Job in Oldenburg &amp; Umgebung!</h3>
            <h3 class="center">Für Studenten und Absolventen</h3>

            <!--später die Breite aller Inputfelder einheitlich gestalten, bei dieser Abgabe zeitlich nicht geschafft-->
            <div class="search">
                <form action="suchergebnisse.php" method="get">
                    <p class="center"><label>
                            <input type="text" name="plz" class="form-control form-control-lg" maxlength="5" value="" placeholder="Deine PLZ" required autofocus>
                            <!--Später mit pattern Attribut absichern?-->
                        </label></p>

                    <p class="center"><label>
                            <select name="umkreis" class="custom-select custom-select-lg" size="1" required>
                                <option value="">Umkreis auswählen</option>
                                <option value="5">5 km</option>
                                <option value="10">10 km</option>
                                <option value="15">15 km</option>
                                <option value="20">20 km</option>
                                <option value="25">25 km</option>
                                <option value="30">30 km</option>
                                <option value="50+">50+ km</option>
                            </select>
                        </label></p>

                    <p class="center"><label>
                            <select name="fachrichtung" class="custom-select custom-select-lg" size="1">
                                <option value="">Fachrichtung auswählen</option>
                                <option value="fr1">Bildungs- und Sozialwissenschaften</option>
                                <option value="fr2">Informatik, Wirtschafts- und Rechtswissenschaften</option>
                                <option value="fr3">Sprach- und Kulturwissenschaften</option>
                                <option value="fr4">Human- und Gesellschaftswissenschaften</option>
                                <option value="fr5">Mathematik und Naturwissenschaften</option>
                                <option value="fr6">Medizin und Gesundheitswissenschaften</option>
                            </select>
                        </label></p>

                    <p class="center"> <input type="submit" value="Los!" class="btn btn-primary"></p>
                </form>
            </div>
            <div>
                <?php if ( isset ($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) { ?>                                    
                    <h3> Soll hier etwas stehen wenn man eingelogt ist? </h3>
                
                <?php } else { ?>
                
                    <h3 class="center"><a href="login.php" class="btn btn-primary">Anmeldung/Registrierung für Arbeitgeber</a></h3>
                
                <?php } ?>

            </div>
        </section>
    </div>

    <?php
        include "php/footer.php";
    ?>
</body>
</html>
<?php

ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();
?>

<!DOCTYPE HTML>
<html lang="de">  
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="bilder/favicon-16x16.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/Queries.css">


    <title>OSJB - About</title>
</head>

<body>
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
    
    <div class="row">
        <div class="container col-md-3">
            <section>
                <h2>
                    Unser Ziel
                </h2>
                <p>
                    <img src="bilder/about.png" class="img-fluid mx-auto d-block rounded img_about mb-3" alt="text">


                    Unser Ziel ist es, Studierenden und Absolventen dabei zu helfen,
                    den perfekten Job zu finden! Darum haben wir uns dazu entschlossen, eine Platform zu gründen die auf die
                    Bedürfnisse und Qualifikationen von Akademikern zugeschnitten ist. Egal ob Praktikum, Werkstudenten- oder
                    Minijob; bei uns findest du eine breite Auswahl von Angeboten in deiner Nähe die auch mit deinem
                    Studienalltag/Stundenplan vereinbar sind! Uns liegen die lokale Unternehmen und Start Ups am Herzen, deswegen
                    möchten wir den Bewerbngsablauf so einfach und unbürokratisch wie möglich gestalten.
                </p>
            </section>
        </div>

        <div class="container col-md-3">
            <section>
                <h2>
                    Wie funktioniert's?
                </h2>
                <p>
                    <img src="bilder/2.jpg" class="img-fluid mx-auto d-block rounded img_about mb-3" alt="text">

                    Gib einfach auf unserer Startseite deine Postleitzahl, den gewünschten Umkreis und deine Fakultät an, wo du
                    sudierst oder deinen Abschluss gemacht hast. Über die Filterfunktionen kannst du dann die Beschäftigungsart,
                    Zeitintensität, etc auswählen. Über den Button "bewerben!" gelangst du direkt auf die Seite des Unternehmens
                    wo du deine Unterlagen einreichen kannst. <br>
                    <br>
                    Für dich als Arbeitnehmer ist somit keine Registrierung erforderlich!
                </p>
            </section>
        </div>

        <div class="container col-md-3">
            <section>

                <h2>
                    Für Arbeitgeber
                </h2>
                <p>
                    <img src="bilder/1.jpg" class="img-fluid mx-auto d-block rounded img_about mb-3" alt="text">

                    Sofern Sie selbst eine Jobanzeige aufgeben möchten, bitten wir Sie sich zu registrieren und ein Profil zu hinterlegen.
                </p>
            </section>

        </div>
    </div>
    <?php
        include "php/footer.php";
    ?>

</body>
</html>
<?php

include('php/calc-job.php'); 

/*ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();*/
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

    <title>OSJB - Jobangebot anzeigen</title>
</head>

<body>
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
    
    <!--Alles nur anzeigen wenn ein exitierendes Jobangebot ausgewählt wurde, sonst Fehlermeldung-->
    <?php if($jobs == null){ ?>
    
    <p class="center">Dieses Jobangebot existiert nicht.</p>
    
    <?php } else { ?>
    
    <div class="container border">
        <div class="row">
            <section class="col-md-4 last_td center">
                <img class="img-fluid" src="bilder/logo.png" alt="Firmenlogo" width="232" height="232">
            </section>

            <section class="col-md-8 last_td">
                <h5><?php echo($art); ?> - <?php echo($titel); ?></h5>
                <p>Zeitintensität: <?= $zeitintensitaet ?> </p>
                <p>Beschäftigungsbeginn: <?= $beschaeftigungsbeginn ?> </p>
                
                <!--<p>Firma: (fehlt noch in der DB)</p>-->
                
                <p>Adresse des Arbeitsplatz: <?= $strasse . " " . $hausnr . " " . $plz . " " . $stadt ?> </p> <!--später alternativer Standort ggf. möglich?-->
                
            <!--später hinzufügen?
                <p>(Optional): Kontaktperson: Max Mustermann</p>
                <p>(Optional): E-Mailadresse: ABC@irgendwas.test</p>
            -->
                
            </section>
        </div>

        <section>
            <h4 class="center">Gesuchte Qualifikationen:</h4>
            <!--Es wird ggf. nur das angezeigt, was auch vorhanden ist? lieber als sub-array zurückgeben?-->
            <div class="row">
                <div class="col-md-4">
                    <p>Liste der angegebenen Abschlüsse: </p>
                    <ul>
                        <?php if( $im_bachelor == 1){ ?> <li> Aktuell im Bachelorstudium </li> <?php } ?>
                        <?php if( $bachelor == 1){ ?> <li> Abschlossener Bachelor </li> <?php } ?>
                        <?php if( $im_master == 1){ ?> <li> Aktuell im Masterstudium </li> <?php } ?>
                        <?php if( $master == 1){ ?> <li> Abschlossener Master </li> <?php } ?>
                        <?php if( $ausbildung == 1){ ?> <li> Abgeschlossene Ausbildung </li> <?php } ?>
                    </ul>
                </div>
                
            <!--Inhaltsreduzierung
                <div class="col-md-4">
                    <p>Liste der angegebenen Module</p>
                    <ul>
                        <li>Merkmal1</li>
                        <li>Merkmal2</li>
                        <li>Merkmal3</li>
                    </ul>
                </div>
                <div class="col-md-4 last_td">
                    <p>Liste der angegebenen Fähigkeiten</p>
                    <ul>
                        <li>Merkmal1</li>
                        <li>Merkmal2</li>
                        <li>Merkmal3</li>
                    </ul>
                </div>
            -->
                
            </div>            
        </section>

        <section>
            <h5>Weitere Beschreibung des Jobangebots: </h5> <!--(Falls vorhanden: Inhalt des Textfelds mit individueller Beschreibung)-->
            <p> <?= $beschreibung ?> </p>
            <!--<p><img src="dummy" alt="Bild mit individueller Beschreibung des Jobangebots" width="10" height="10"> (Nur angezeigt falls vorhanden?)-->
        </section>

        <section class="end">
            <!--(Link zur Seite des Unternehmens (Falls Link angegeben wurde)-->
            <?php if( $link != ""){ ?>
                <a href="https://<?= $link ?>" class="btn btn-primary" role="button">Direkt beim Unternehmen bewerben</a>
            <?php } ?>
        </section>
    </div>

    <?php } //End of else ?>
    
    <?php
        include "php/footer.php";
    ?>
</body>

</html>
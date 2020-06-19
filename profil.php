<?php
ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();

include('php/calc-job.php');
?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="bilder/favicon-16x16.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>OSJB - Profil</title>
</head>

<body>
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
    
    <!--Alles nur anzeigen wenn eingelogt, sonst Fehlermeldung-->
    <?php if(!isset($_SESSION["eingeloggt"]) || $_SESSION["eingeloggt"] != true){ ?>
    
    <p class="center">Bitte anmelden!</p>
    
    <?php } else { ?>

    
    <div class="container-fluid">
        <div class="container border">
            <section>
                
 <!--Durch überprüfung von $_SESSION["update"] = "failed"; prüfen ob update fehlgeschlagen ist -> meldung ausgeben und $_SESSION["update"] auf "false" ändern-->
                
                <form action="php/config-reg.php" method="post">
                    <h3 class="center mb-3">Profil von <?php echo($_SESSION["vorname"] . " " . $_SESSION["nachname"]) ?> </h3>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="firma">Firma:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="firma" name="firma" readonly>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="logo">Firmenlogo:</label>
                        </div>
                        <div class="col-sm">
                            <input class="btn btn-secondary" type="file" name="logo" id="logo">  <!--Sicherstellen, dass nur Bilder hochgeladen werden?-->
                        </div>
                    </div>    
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="vorname">Vorname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="vorname" name="vorname" readonly>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="nachname">Nachname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="nachname" name="nachname" readonly>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="email">Email:</label>
                        </div>
                        <div class="col-sm">
                            <input type="email" id="email" name="email">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="password">Passwort:</label>
                        </div>
                        <div class="col-sm">
                            <input type="password" id="password" name="passwort">
                        </div>
                    </div>

                    <div class="form-group">
                        <h4>Adresse:
                            <!-- <input type="button" value="Bearbeiten" class="btn btn-secondary"-->
                        </h4>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="straße">Straße:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="straße" name="strasse">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="straße">Hausnummer:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="hausnr" name="hausnr">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="plz">PLZ:</label>
                        </div>
                        <div class="col-sm">
                            <input type="number" id="plz" name="plz">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="stadt">Stadt:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="stadt" name="stadt">
                        </div>
                    </div>

                <!--Inhaltsreduzierung
                    <div class="form-group">
                        <input type="button" value="Bearbeiten" class="btn btn-secondary">
                    </div>
                -->

                    <div class="form-group ">
                        <input type="submit" value="Daten aktualisieren" name="updaten" class="btn btn-primary">
                    </div>
                </form>
            </section>
        </div>

        <div class="container border">
            <section>
                <h4 class="center">Meine Anzeigen</h4>
                <p>
                    <a href="jobangebot-anlegen.php" class="btn btn-primary">Anzeige erstellen</a>
                </p>

                <?php 
                    $count = 0;
                    foreach($jobs as $job): 
                        extract($job);
                        $count++;
                ?>

                <div class="border">
                    <a class="mr-3" href="jobangebot-anzeigen.php?id=<?php echo($id)?>"> <?php echo($bez)?></a>
                    
                <!--Inhaltsreduzierung
                    (Datum an dem Jobangebot erstellt wurde)
                    (Jobangeobt aktiv/inaktiv)
                -->

                    <a href="jobangebot-anlegen.php?id=<?php echo($id)?>" class="btn btn-secondary mr-3">Bearbeiten</a>

                    <a href="profil.php?del=1&id=<?php echo($id)?>" class="btn btn-light">Löschen</a>
                </div>

                <?php endforeach; ?>

                <p class="center">Ende der Liste. Es wurden <?php echo $count ?> Jobangebote gefunden.</p>

            </section>
        </div>
    </div>

    <?php } //End of else ?>
    
    <?php
        include "php/footer.php";
    ?>
</body>

</html>

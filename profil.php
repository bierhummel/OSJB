<?php
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

    <div class="container-fluid">
        <div class="container border">
            <section>
                <form action="php/config-profil.php" method="post">
                    <h3 class="center mb-3">Profil von (Name):</h3>
                    <div class="row form-group">
                        <div class="col">
                            <label for="name">Vorname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="name" name="name" readonly>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="name">Nachname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="name" name="name" readonly>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="name">Firma:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="name" name="name" readonly>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="name">Firmenlogo:</label>
                        </div>
                        <div class="col-sm">
                            <input class="btn btn-secondary" type="file" name="image">  <!--Sicherstellen, dass nur Bilder hochgeladen werden?-->
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
                            <label for="password">Passwort:&nbsp;&nbsp;</label>
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
                            <input type="text" id="straße" name="straße">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="straße">Hausnummer:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="straße" name="straße">
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
                        <input type="submit" value="Absenden" name="ab" class="btn btn-primary">
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

    <?php
        include "php/footer.php";
    ?>
</body>

</html>

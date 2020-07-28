<?php
/*ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();*/

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
    
    <script src="javascript/check-userinputs.js" async></script>

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
                    <h3 class="center mb-5">
                        Profil von 
                        <?= $_SESSION["vname"] . " " . $_SESSION["nname"];?> 
                    </h3>
                    
                    <!--Rückmeldung zum Update übergangsweise hier anzeigen-->
                    <p>
                        <?php if (isset ($_SESSION["update"]) ) {
                            if($_SESSION["update"] == "fail") { ?>
                                Fehler beim Update. (Übergangslösung)
                            <?php } elseif ($_SESSION["update"] == "success") { ?>
                                Nutzerdaten erfolgreich aktualisiert. (Übergangslösung)
                            <?php } $_SESSION["update"] = ""; } 
                        ?>
                    </p>
                    
                    <!--email-->
                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="new_email">E-Mail:</label>
                        </div>
                        <div class="col-sm">
                            <?= $_SESSION["mail"] ?>
                            
                            <!--Mail lieber nicht änderbar machen?
                            <input type="email" id="new_email" name="new_email" value="<?= $_SESSION["mail"] ?>">-->
                        </div>
                    </div>
                    
                    <!--passwort ändern später-->
                    <!--
                    <div class="row form-group">                        
                        <div class="col-sm">
                            <label for="password">Passwort:</label>
                        </div>
                        <div class="col-sm">
                            <input type="password" id="password" name="passwort">
                        </div>
                    </div>
                    -->
                    
                    <!--Firma-->
                    <div class="row form-group">
                        <div class="col">
                            <label for="firma">Firma: </label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="firma" name="new_firma" value="<?= $_SESSION["uname"] ?>">
                        </div>
                    </div>
                    
                    <!--Logo-->
                    <div class="row form-group">
                        <div class="col">
                            <label for="logo">Firmenlogo: (noch in Bearbeitung)</label>
                        </div>
                        <div class="col-sm">
                            <input class="btn btn-secondary" type="file" name="new_logo" id="logo">  <!--Sicherstellen, dass nur Bilder hochgeladen werden?-->
                        </div>
                    </div>    
                    
                    <!--Vorname-->
                    <div class="row form-group">
                        <div class="col">
                            <label for="vorname">Vorname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="vorname" name="new_vorname" value="<?= $_SESSION["vname"] ?>">
                        </div>
                    </div>
                    
                    <!--Nachname-->
                    <div class="row form-group">
                        <div class="col">
                            <label for="nachname">Nachname:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="nachname" name="new_nachname" value="<?= $_SESSION["nname"] ?>">
                        </div>
                    </div>

                    <!--Adresse-->
                    <div class="form-group">
                        <h6>Adresse:
                            <!-- <input type="button" value="Bearbeiten" class="btn btn-secondary"-->
                        </h6>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="strasse">Straße:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="strasse" name="new_strasse" value="<?= $_SESSION["strasse"] ?>">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="straße">Hausnummer:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="hausnr" name="new_hausnr" value="<?= $_SESSION["hausnr"] ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="plz">PLZ:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="plz" name="new_plz" value="<?= $_SESSION["plz"] ?>" maxlength="5">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm">
                            <label for="stadt">Stadt:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="stadt" name="new_stadt" value="<?= $_SESSION["stadt"] ?>">
                        </div>
                    </div>

                <!--Inhaltsreduzierung
                    <div class="form-group">
                        <input type="button" value="Bearbeiten" class="btn btn-secondary">
                    </div>
                -->
                    
                    
                    <!--Submit des Update der Userdaten und Hidden-Input für CSRF-Token-->
                    <div class="form-group ">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                        
                        <input type="submit" value="Daten aktualisieren" name="updaten" class="btn btn-primary">
                    </div>
                </form>
            </section>
        </div>

        <div class="container border">
            <section>
                <h4 class="center">Meine Jobangebote</h4>
                <p class="center"> 
                    <?php 
                        if( isset($_SESSION["UpdateError"]) && $_SESSION["UpdateError"] != ""){
                            echo $_SESSION["UpdateError"];
                            $_SESSION["UpdateError"] = "";
                        }
                        if( isset($_SESSION["DeleteError"]) && $_SESSION["DeleteError"] != ""){
                            echo $_SESSION["DeleteError"];
                            $_SESSION["DeleteError"] = "";
                        }
                    ?>
                </p>
                
                <p>
                    <a href="jobangebot-anlegen.php" target="_blank" class="btn btn-primary">Neues Jobangebot erstellen</a>
                </p>

                <?php 
                    $count = 0;
                    if($jobs != null){ 
                        foreach($jobs as $job): 
                            extract($job);
                            $count++;
                ?>

                <div class="border">
                    <!--Jobangebot anzeigen-->
                    <a class="mr-3" target="_blank" href="jobangebot-anzeigen.php?id=<?php echo($id)?>"> <?php echo($titel)?></a>
                    
                <!--Inhaltsreduzierung
                    (Datum an dem Jobangebot erstellt wurde)
                    (Jobangeobt aktiv/inaktiv)
                -->
                    
                    <!--Bearbeiten eines Jobangebotes-->
                    <form action="jobangebot-anlegen.php" method="post" target="_blank" class="mini-form">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="submit" name="aufruf_job-bearbeiten" value="Bearbeiten" class="btn btn-secondary mr-3">
                    </form>
                    
                    <!--Löschen eines Jobangebotes-->
                    <form action="php/calc-job.php" method="post" class="mini-form">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="del" value="1">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                        <input type="checkbox" name="check_del" required>
                        <input type="submit" name="aufruf_job-bearbeiten" value="Löschen" class="btn btn-light">
                    </form>
                </div>

                <?php endforeach; } ?>

                <p class="center">Ende der Liste. Es wurde(n) <?php echo $count ?> Jobangebot(e) gefunden.</p>

            </section>
        </div>
    </div>

    <?php } //End of else ?>
    
    <?php
        include "php/footer.php";
    ?>
</body>

</html>

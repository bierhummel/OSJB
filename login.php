<?php
ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();

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

    <title>OSJB - Login</title>
</head>

<body>

    <?php
        $title = "OSJB";
        include "php/header.php";

        //Alles nur anzeigen wenn nicht eingelogt, sonst Weiterleitung ins Profil
        if(isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == true){ 
            header( 'location: profil.php' );
            exit;
        }
        else { 
    ?>
    
    <div id = "font-login">
    <div class="row">
        
        <!--Login-->
        <div class="container col-xl-4 border ">
            <section id="login">
                <form action="php/process-userDAO.php" method="post" class="">
                    <fieldset>
                        <legend>Login:</legend>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="email">E-Mail:</label>                    
                            </div>
                            <div class="col-sm">
                                <input type="email" id="email" placeholder="E-Mail" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="passwort">Passwort:</label>
                            </div>
                            <div class="col-sm">
                                <input type="password" id="passwort" placeholder="Passwort" name="passwort" value="" minlength="8" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-check d-flex align-items-end flex-column ">
                            <input type="submit" class="btn btn-primary m-2 " name="login" value="Login">
                        </div>
                         
                        <!--Inhaltreduzierung
                            <div class="form-check d-flex align-items-end flex-column">
                                <input type="button" class="btn btn-light  " value="Passwort vergessen">
                            </div>
                        -->
                    
                        <?php 
                            //Rückmeldung zur Anmeldung anzeigen
                            if (isset ($_SESSION["login"]) ) {
                                if($_SESSION["login"] == "fail") { ?>
                                    Anmedlung fehlgeschlagen.
                                <?php } $_SESSION["login"] = ""; 
                            } 
                        ?>                        
                    </fieldset>
                </form>
            </section>
        </div>
        
        <!--Registrierung-->
        <div class="container col-xl-4 border">
            <section id="registrierung">
                <form action="php/process-userDAO.php" method="post" class="">
                    <fieldset>
                        <legend>Registrierung:</legend>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="firma">Firma:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="firma" placeholder="" name="firma" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="vorname">Vorname:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="vorname" placeholder="" name="vorname" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="nachname">Nachname:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="nachname" placeholder="" name="nachname" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col">
                                <label for="r_email">E-Mail:</label>
                            </div>
                            <div class="col-sm">
                                <input type="email" id="r_email" placeholder="" name="email1" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="r_passwort">Passwort:</label>
                            </div>
                            <div class="col-sm">
                                <input type="password" id="r_passwort" placeholder="" name="passwort1" minlength="8" class="form-control" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="r_passwort2">Passwort bestätigen:</label>
                            </div>
                            
                            <div class="col-sm">
                                <input type="password" id="r_passwort2" placeholder="" name="passwort2" minlength="8" class="form-control" required>
                            </div>
                        </div>
                        
                        <!--Nutzungsbedingungen und Datenschutz-->
                        <div class="row form-group">
                            <div class="col-sm-8">
                                <label for="NB_DS_check">
                                    <a href="nutzungsbedingungen.php" target="_blank">Nutzungsbedingunen </a> 
                                    und
                                    <a href="datenschutz.php" target="_blank">Datenschutzerklärung </a> 
                                    akzeptieren.
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input type="checkbox" id="NB_DS_check" name="NB_DS_check" class="form-control" required>
                            </div>
                        </div>
                        
                        <?php 
                            //Rückmeldung zur Registrierung übergangsweise anzeigen
                            if( isset($_SESSION["registrierung"]) ) {

                                //Durch überprüfung von $_SESSION["registriert"] prüfen ob und warum Registrierung fehlgeschlagen ist -> entsprechende Meldung ausgeben und $_SESSION["registriert"] auf "false" ändern
                                if($_SESSION["registrierung"] == "pw_fail") { ?>
                                    Achtung: Passwörter sind nicht gleich!
                                <?php } elseif ($_SESSION["registrierung"] == "db_fail") { ?>
                                    Unbekannter Fehler bei Registrierung. Probieren Sie es bitte erneut.
                                <?php } elseif ($_SESSION["registrierung"] == "verifizierung") { ?>
                                   Erfolgreiche Registrierung.<br> Ihnen wurde eine <a target="_blank" href="<?= $_SESSION["tokenpfad"]?>">Bestätigungsmail</a> zugesendet.
                                <?php } elseif ($_SESSION["registrierung"] == "token_fail") { ?>
                                    Kein entsprechender Registrierungs-Token vorhanden. Prüfen Sie bitte den Link in Ihrer Bestätigungsmail.
                                <?php } elseif ($_SESSION["registrierung"] == "success") { ?>
                                    Benutzer erfolgreich registiert. Bitte anmelden Sie sich an.
                                <?php } $_SESSION["registrierung"] = ""; 
                            } 
                        ?>
                        
                        <div class="form-group d-flex align-items-end flex-column">
                            <input type="submit" class="btn btn-primary" id="registrieren" name="registrieren" value="Registrieren">
                       </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </div>
    </div> 
    
    <?php 
        } //End of else 
        
        include "php/footer.php";
    ?>
</body>

</html>

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

    <title>OSJB - Login</title>
</head>

<body class="background_login">

    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>

    <!--Später über Javascript vllt nur eins von beiden anzeigen lassen und über knopf Ansicht wechseln-->
    <div class="row">
        <div class="container col-xl-4 border ">
            
            <section id="login">
    <!--Durch überprüfung von $_SESSION["eingeloggt"] = "failed"; prüfen ob anmeldung fehlgeschlagen ist -> meldung ausgeben und $_SESSION["eingeloggt"] auf "false" ändern-->
                <form action="php/config-reg.php" method="post" class="was-validated">
                    <fieldset>
                        <legend>Log in:</legend>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="email">Email:</label>                    
                            </div>
                            
                            <div class="col-sm">

                                <input type="email" id="email" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Bitte ausfüllen </div>


                        <div class="row form-group">

                            <div class="col-sm">

                                <label for="passwort">Passwort:</label>
                            </div>

                            <div class="col-sm">

                                <input type="password" id="passwort" placeholder="Passwort" name="passwort" value="" required>

                            </div>
                        </div>

                    <!--Inhaltreduzierung
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Bitte ausfüllen.</div>
                        <div class="form-check d-flex align-items-end flex-column">

                            
                            <input type="checkbox" class="custom-control-input" id="customCheck" name="ckbox">
                            <label class="custom-control-label" for="customCheck">Angemeldet bleiben</label>
                        </div>
                    -->
                        
                        <div class="form-check  d-flex align-items-end flex-column ">
                            <input type="submit" class="btn btn-primary m-2 " name="login" value="Login">
                        </div>
                        
                    <!--Inhaltreduzierung
                        <div class="form-check d-flex align-items-end flex-column">
                            <input type="button" class="btn btn-light  " value="Passwort vergessen">
                        </div>
                    -->
                        
                    </fieldset>
                </form>
            </section>
        </div>
        
        
        <div class="container col-xl-4 border">
            <section id="registrierung">
 <!--Durch überprüfung von $_SESSION["registriert"] = "failed"; prüfen ob registrierung fehlgeschlagen ist -> meldung ausgeben und $_SESSION["registriert"] auf "false" ändern-->
                <form action="php/config-reg.php" method="post" class="was-validated">
                    <fieldset>
                        <legend>Registrierung:</legend>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="firma">Firma:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="name" placeholder="" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="vorname">Vorname:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="name" placeholder="" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="nachname">Nachname:</label>
                            </div>
                            <div class="col-sm">
                                <input type="text" id="name" placeholder="" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col">
                                <label for="r_email">Email:</label>
                            </div>
                            <div class="col-sm">

                                <input type="email" id="r_email" placeholder="" name="email1" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="r_passwort">Passwort:</label>
                            </div>
                            <div class="col-sm">
                                <input type="password" id="r_passwort" placeholder="" name="passwort1" minlength="8" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="r_passwort2">Passwort bestätigen:</label>
                            </div>
                            
                            <div class="col-sm">
                                <input type="password" id="r_passwort2" placeholder="" name="passwort2" minlength="8" required>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-end flex-column">
                            <input type="submit" class="btn btn-primary" name="registrieren" value="Registrieren">
                        </div>
                    </fieldset>
                </form>

            </section>
        </div>

    </div>

    <?php
        include "php/footer.php";
    ?>
</body>

</html>

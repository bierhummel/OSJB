<?php

ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();

include('php/process-jobDAO.php'); 
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

    <title>OSJB - Jobangebot anlegen</title>
</head>

<body class ="background_anlegen">
    
    <?php
        $title = "OSJB";
        include "php/header.php";

        //Alles nur anzeigen wenn eingelogt, sonst Fehlermeldung
        if(!isset($_SESSION["eingeloggt"]) || $_SESSION["eingeloggt"] != true){ 
    ?>
    
            <p class="center">Bitte anmelden!</p>
    
    <?php 
        } 
        //Wurde eine ID übergeben, aber trotzdem kein Job gefunden -> Fehlermeldung
        elseif( isset($request_checked["id"]) && $jobs == null ) { 
    ?>
            <p class="center">Dieses Jobangebot existiert nicht oder es liegen keine Rechte zum Bearbeiten vor.</p>
    
    <?php 
        } 
        //Sonst: Seite anzeigen
        else { 
    ?>
    
    <div id = "content">
    <div class="container border">
        <section>
            <form action="php/process-jobDAO.php" method="post">
                <!--ID des Jobs wird über Hidden-Feld mitgegeben-->
                <input type="hidden" name="id" value="<?php if($jobs != null) echo $id ?>" >
                
                <section>
                    <h3 class="center">Allgemeine Informationen</h3>
                    <h4 class="center mb-4">Informationen zum Job</h4>

                    <div class="row">
                        <div class="col-md-5 last_td">
                            <select class="form-control" name="art" size="1" required>
                                <option value="">Beschäftigungsart</option>
                                <option value="Festanstellung" <?php if($jobs != null && $art == "Festanstellung"){ ?> selected <?php } ?> >Festanstellung</option>
                                <option value="Praktikum" <?php if($jobs != null && $art == "Praktikum"){ ?> selected <?php } ?> >Praktikum</option>
                                <option value="Aushilfe" <?php if($jobs != null && $art == "Aushilfe"){ ?> selected <?php } ?> >Aushilfe</option>
                                <option value="Werkstudent" <?php if($jobs != null && $art == "Werkstudent"){ ?> selected <?php } ?> >Werkstudent</option>
                                <option value="Volontarioat" <?php if($jobs != null && $art == "Volontarioat"){ ?> selected <?php } ?> >Volontarioat</option>
                                <option value="Minijob" <?php if($jobs != null && $art == "Minijob"){ ?> selected <?php } ?> >Minijob</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label> Jobbezeichnung:
                                <div class="col-md-2">
                                    </div>
                                <input type="text" size="50"name="titel" maxlength="50" value="<?php if($jobs != null) echo($titel); ?>" placeholder="z.B. Softwareentwickler" required>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 last_td">
                            <select class="form-control" name="fachrichtung" size="1">
                                <option value="">Fachrichtung auswählen</option>
                                <option value="Bildungs- und Sozialwissenschaften" <?php if($jobs != null && $fachrichtung == "Bildungs- und Sozialwissenschaften"){ ?> selected <?php } ?> >Bildungs- und Sozialwissenschaften</option>
                                <option value="Informatik, Wirtschafts- und Rechtswissenschaften" <?php if($jobs != null && $fachrichtung == "Informatik, Wirtschafts- und Rechtswissenschaften"){ ?> selected <?php } ?> >Informatik, Wirtschafts- und Rechtswissenschaften</option>
                                <option value="Sprach- und Kulturwissenschaften" <?php if($jobs != null && $fachrichtung == "Sprach- und Kulturwissenschaften"){ ?> selected <?php } ?> >Sprach- und Kulturwissenschaften</option>
                                <option value="Human- und Gesellschaftswissenschaften" <?php if($jobs != null && $fachrichtung == "Human- und Gesellschaftswissenschaften"){ ?> selected <?php } ?> >Human- und Gesellschaftswissenschaften</option>
                                <option value="Mathematik und Naturwissenschaften" <?php if($jobs != null && $fachrichtung == "Mathematik und Naturwissenschaften"){ ?> selected <?php } ?> >Mathematik und Naturwissenschaften</option>
                                <option value="Medizin und Gesundheitswissenschaften" <?php if($jobs != null && $fachrichtung == "Medizin und Gesundheitswissenschaften"){ ?> selected <?php } ?> >Medizin und Gesundheitswissenschaften</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td" >
                            <label title="Geben Sie hier einen Link zu Ihrem firmeneigenen Bewerbungsportal nach dem gegebenen Muster (ohne http oder https) ein" for="blink">
                                Link zur direkten Bewerbung: 
               
                            <div class="col-md-2 ">
                                    </div>
                            <input type="text"  size="50" id="blink" name="blink" maxlength="100" placeholder="www.ihre-seite.de" value="<?php if($jobs != null) echo($link);  ?>">
                            </label>   
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 last_td">
                            <div class="row">
                                <div class="col-12">
                                    Zeitintensität:
                                </div>
                                <div class="col-xl-4 col-6">
                                    <input type="radio" name="zeitintensitaet" id="Teilzeit" value="Teilzeit" <?php if($jobs != null && $zeitintensitaet == "Teilzeit"){ ?> checked <?php } ?> >
                                    <label for="Teilzeit">Teilzeit</label>
                                </div>
                                <div class="col-xl-4 col-6">
                                    <input type="radio" name="zeitintensitaet" id="Vollzeit" value="Vollzeit" <?php if($jobs != null && $zeitintensitaet == "Vollzeit"){ ?> checked <?php } ?> >
                                    <label for="Vollzeit">Vollzeit</label>
                                </div>
                                <div class="col-xl-4 col-6">
                                    <input type="radio" name="zeitintensitaet" id="20h" value="20h" <?php if($jobs != null && $zeitintensitaet == "20h"){ ?> checked <?php } ?> >
                                    <label for="20h">20h</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label>
                                <br>Frühster Beginn der Beschäftigung:
                                <input type="date" name="jdate" value="<?php if($jobs != null) echo($beschaeftigungsbeginn); ?>" required>
                            </label>

                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-12">
                            <h6>Arbeitstelle: </h6>
                        </div>
                        
                         <div class="col-md-5">
                            <label for="job_uname">Unternehmen:</label>
                            <input type="text" id="job_uname" name="job_uname" value="<?= $_SESSION["uname"]?>" disabled readonly>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <label for="logo" title="Nur verfügbar, wenn Logo im Profil hinterlegt">Firmenlogo nutzen:</label>
                            <input type="checkbox" 
                                   id="logo" name="logo" 
                                   value="<?php if( isset($_SESSION["logo"]) ) echo($_SESSION["logo"])?>" 
                                   <?php if( !isset($_SESSION["logo"]) ) echo("disabled")?> 
                                   <?php if( isset($logo) ){ ?> checked <?php } ?>
                                   >
                        </div>
                        
                        <div class="col-md-5">
                            <label for="job_strasse">Straße:</label>
                            <input type="text" id="job_strasse" name="job_strasse" required value="<?php if($jobs != null) {echo($strasse);} else{ echo $_SESSION["strasse"]; } ?>">
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <label for="job_hausnr">Hausnummer:</label>
                            <input type="text" id="job_hausnr" name="job_hausnr" required value="<?php if($jobs != null) {echo($hausnr);} else{ echo $_SESSION["hausnr"]; } ?>" >
                        </div>
                        
                        <div class="col-md-5">
                            <label for="job_plz">PLZ:</label>
                            <input type="text" for="job_plz" name="job_plz" required value="<?php if($jobs != null) {echo($plz);} else{ echo $_SESSION["plz"]; } ?>" maxlength="5">
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label for="job_stadt">Stadt:</label>
                            <input type="text" id="job_stadt" name="job_stadt" required value="<?php if($jobs != null) {echo($stadt);} else{ echo $_SESSION["stadt"]; } ?>">
                        </div>
                    </div>

                    <!--Inhaltsreduzierung
                        <div class="row">
                            !--später nur angezeigt falls vorhanden?--
                            <div class="col-md-12 center">
                                (Optional): Kontaktperson: Max Mustermann
                            </div>
                            <div class="col-md-12 center">
                                (Optional): E-Mailadresse: ABC@irgendwas.test
                            </div>
                        </div>
                        !--(Werte später automatisch aus Profil des Arbeitgebers übertragen)--
                    -->
                    
                </section>
                <hr>

                <section>
                    <h3 class="center">Gesuchte Qualifikationen</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            Abschlüsse:
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <input type="checkbox" id="abachelor" name="abachelor" value="abachelor" <?php if($jobs != null && $bachelor == 1){ ?> checked <?php } ?> > 
                            <label for="abachelor">Bachelor</label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="amaster" value="amaster" <?php if($jobs != null && $master == 1){ ?> checked <?php } ?> > Master
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="ibachelor" value="ibachelor" <?php if($jobs != null && $im_bachelor == 1){ ?> checked <?php } ?> > Im Bachelor immatrikuliert
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="imaster" value="imaster" <?php if($jobs != null && $im_master == 1){ ?> checked <?php } ?> > Im Master immatrikuliert
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6 last_td">
                            <label>
                                <input type="checkbox" name="ausbildung" value="ausbildung" <?php if($jobs != null && $ausbildung == 1){ ?> checked <?php } ?> > Zus. berufliche Ausbildung
                            </label>
                        </div>
                    </div>

                <!--Inhaltsreduzierung
                    <div class="row">
                        <div class="col-lg-5 last_td">
                        !--Später ermöglichen, dass beliebig viele Module + Fähigkeiten angegeben werden.. js?--
                            <label>
                                Module:
                                <input class="form-control" list="module">
                                <datalist id="module">
                                    <option value="Internettechnologien">
                                    <option value="Rechnernetze 1">
                                    <option value="Buchhaltung und Abschluss">
                                </datalist>
                            </label>
                        </div>
                        <div class="col-lg-2">
                        </div>                    
                        !--Falls möglich eine Liste aller Module der Uni Oldenburg einbinden--
                        <div class="col-lg-5 last_td">
                            <label>
                                Besondere Fähigkeiten und Kenntnisse:
                                <input class="form-control" list="fähigkeiten">
                                <datalist id="fähigkeiten">
                                    <option value="Progammierung Java">
                                    <option value="Webprogrammierung">
                                    <option value="Zehnfingerschreiben">
                                </datalist>
                            </label>
                        </div>
                    </div>
                -->
                </section>

                <section>
                    <h3 class="center">Individuelle Beschreibung</h3>
                
                    <!--Inhaltsreduzierung
                        <div class="row">
                            <div class="col">
                                <p>Bitte füllen Sie das Textfeld mit einer individuellen Beschreibung aus und/oder laden Sie ein entsprechendes Dokument hoch.</p>
                            </div>                                                
                        </div>


                        <div class="row">
                            <div class="col-lg-6 last_td">
                                 <textarea class="form-control" name="message" rows="10" cols="100"></textarea>                        
                            </div>
                            <div class="col-lg-2_">
                            </div>
                            <div class="col-lg-6 last_td align-self-center">
                                <label>
                                    Bild hochladen:
                                    <input class="btn btn-secondary" type="file" name="image">

                                    !--Sicherstellen, dass nur Bilder hochgeladen werden?)--
                                </label>
                            </div>                                            
                        </div>
                    -->

                    <!--(Übergangsweise?) Nur Textfeld statt Textfeld + Upload-->
                    
                    <div class="row">
                        <div class="col">
                            <p>Bitte füllen Sie das Textfeld mit einer individuellen Beschreibung aus.</p>
                        </div>                                                
                    </div>
                    <div class="row">
                        <div class="col-lg-12 last_td">
                             <textarea class="form-control" name="message" rows="10" cols="100"><?php if($jobs != null) echo($beschreibung); ?></textarea>                        
                        </div>                                                       
                    </div>
                </section>
                
                <div class="row end">
                    <div class="col-md-4 col-lg-6">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                       <!-- <button class="btn btn-secondary" type="button">Vorschau</button> (Soll eine Vorschau anzeigen)-->                            
                    </div>
                    
                    <!--csrf-token-->
                     <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                    
                    <div class="col-6 col-md-4 col-lg-3">
                        <?php if($jobs != null) { ?>
                            <input type="submit" class="btn btn-primary" name="bearbeiten" value="Jobangebot bearbeiten">
                        <?php } else { ?>
                            <input type="submit" class="btn btn-primary" name="erstellen" value="Jobangebot erstellen">
                        <?php } ?>
                    </div>
                </div>
                
            </form>
        </section>
    </div>
    </div>
    
    <?php 
        } //End of else
    
        include "php/footer.php";
    ?>

</body>
</html>
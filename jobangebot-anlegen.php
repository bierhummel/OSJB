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

    <title>OSJB - Jobangebot anlegen</title>
</head>

<body class ="background_anlegen">
    
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
    
    <!--Alles nur anzeigen wenn eingelogt, sonst Fehlermeldung-->
    <?php if(!isset($_SESSION["eingeloggt"]) || $_SESSION["eingeloggt"] != true){ ?>
    
        <p class="center">Bitte anmelden!</p>
    
    <?php } else { ?>    

    <div class="container border">
        <section>
            <form action="php/calc-job.php" method="post">
                <!--Übergangslösung, wird geändert sobald Aufruf von bearbeiten geändert-->
                <input type="hidden" name="update_id" value="<?= $id ?>" >
                
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
                                <input type="text" name="titel" maxlength="50" value="<?php if($jobs != null) echo($titel); ?>" placeholder="Jobbezeichnung" required>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 last_td">
                            <select class="form-control" name="fachrichtung" size="1" required>
                                <option value="">Fachrichtung auswählen</option>
                                <option value="Bildungs- und Sozialwissenschaften" <?php if($jobs != null && $fachrichtung == "Bildungs- und Sozialwissenschaften"){ ?> selected <?php } ?> >Bildungs- und Sozialwissenschaften</option>
                                <option value="Informatik, Wirtschafts- und Rechtswissenschaften" <?php if($jobs != null && $fachrichtung == "Informatik, Wirtschafts- und Rechtswissenschaften"){ ?> selected <?php } ?> >Informatik, Wirtschafts- und Rechtswissenschaften</option>
                                <option value="Sprach- und Kulturwissenschaften" <?php if($jobs != null && $fachrichtung == "Sprach- und Kulturwissenschaften"){ ?> selected <?php } ?> >Sprach- und Kulturwissenschaften</option>
                                <option value="Human- und Gesellschaftswissenschaften" <?php if($jobs != null && $fachrichtung == "Human- und Gesellschaftswissenschaften"){ ?> selected <?php } ?> >Human- und Gesellschaftswissenschaften</option>
                                <option value="Mathematik und Naturwissenschaften" <?php if($jobs != null && $fachrichtung == "Mathematik und Naturwissenschaften"){ ?> selected <?php } ?> >Mathematik und Naturwissenschaften</option>
                                <option value="Medizin und Gesundheitswissenschaften" <?php if($jobs != null && $fachrichtung == "Medizin und Gesundheitswissenschaften"){ ?> selected <?php } ?> >Medizin und Gesundheitswissenschaften</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                        </div>
                        <div class="col-lg-5 last_td">
                            <label>
                                <!--später min=(heute)-->
                                Frühster Beginn der Beschäftigung:
                                <input type="date" name="jdate" value="<?php if($jobs != null) echo($beschaeftigungsbeginn); ?>" required>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 last_td">
                            <div class="row">
                                <div class="col-12">
                                    Zeitintesität:
                                </div>
                                <div class="col-xl-4 col-6">
                                    <!--Später mindestens eine Angabe required festlegen.. js?-->
                                    <label>
                                        <input type="checkbox" name="teilzeit" value="Teilzeit" <?php if($jobs != null && $zeitintensitaet == "Teilzeit"){ ?> checked <?php } ?> > Teilzeit
                                    </label>
                                </div>
                                <div class="col-xl-4 col-6">
                                    <label>                                        
                                        <input type="checkbox" name="vollzeit" value="Vollzeit" <?php if($jobs != null && $zeitintensitaet == "Vollzeit"){ ?> checked <?php } ?> > Vollzeit
                                    </label>
                                </div>
                                <div class="col-xl-4 col-12">
                                    <label>                                        
                                        <input type="checkbox" name="20h" value="20h" <?php if($jobs != null && $zeitintensitaet == "20h"){ ?> checked <?php } ?> > &lt;20h/Woche
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label title="Geben Sie hier einen Link zu Ihrem firmeneigenen Bewerbungsportal ein" for="blink">
                                Link zur direkten Bewerbung (optional): 
                            </label>    
                            <input type="text" id="blink" name="blink" maxlength="50" placeholder="www.ihre-seite.de" value="<?php if($jobs != null) echo($link); ?>">
                            
                        </div>
                    </div>

                    <!--
                    <h4 class="center">Informationen zum Unternehmen "<?= $_SESSION["uname"]?>"</h4>
                    
                    <div class="row">
                        <div class="col-md-12">
                            Firma: <?= $_SESSION["uname"]?>
                        </div>
                        <div class="col-md-12 last_td">
                            Adresse: <?= $_SESSION["strasse"] . " " . $_SESSION["hausnr"] . " " . $_SESSION["plz"] . " " . $_SESSION["stadt"] ?>
                        </div>
                    </div>
                    -->
                    
                    <div class="row">
                        <div class="col-12">
                            <h6>Arbeitstelle: </h6>
                        </div>
                        
                         <div class="col-md-12">
                            <label for="job_uname">Unternehmen:</label>
                            <input type="text" id="job_uname" name="job_uname" value="<?= $_SESSION["uname"]?>" readonly>
                        </div>
                        <div class="col-md-5">
                            <label for="job_strasse">Straße:</label>
                            <input type="text" id="job_strasse" name="job_strasse" value="<?php if($jobs != null) {echo($strasse);} else{ echo $_SESSION["strasse"]; } ?>">
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <label for="job_hausnr">Hausnummer:</label>
                            <input type="text" id="job_hausnr" name="job_hausnr" value="<?php if($jobs != null) {echo($hausnr);} else{ echo $_SESSION["hausnr"]; } ?>" >
                        </div>
                        <div class="col-md-5">
                            <label for="job_plz">PLZ:</label>
                            <input type="text" for="job_plz" name="job_plz" value="<?php if($jobs != null) {echo($plz);} else{ echo $_SESSION["plz"]; } ?>" maxlength="5">
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label for="job_stadt">Stadt:</label>
                                <input type="text" id="job_stadt" name="job_stadt" value="<?php if($jobs != null) {echo($stadt);} else{ echo $_SESSION["stadt"]; } ?>">
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
                    <h3 class="center">Gesuchte Qualifikationen (optional)</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            Abschlüsse:
                            <!--(Lieber auch als datalist?)-->
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
                    <h3 class="center">Individuelle Beschreibung (optional)</h3>
                
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
                <!--Ende Übergangslösung-->
                    
                </section>
                
                <div class="row end">
                    <div class="col-md-4 col-lg-6">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                       <!-- <button class="btn btn-secondary" type="button">Vorschau</button> (Soll eine Vorschau anzeigen)-->                            
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <?php if($_GET["new"]==1){ ?>                    
                            <input type="submit" class="btn btn-primary" name="erstellen" value="Jobanzeige erstellen"> <!---(Danach Jobangebot anzeigen)-->
                        <?php } else { ?>
                            <input type="submit" class="btn btn-primary" name="bearbeiten" value="Jobanzeige bearbeiten"> <!---(Danach Jobangebot anzeigen)-->
                        <?php } ?>
                    </div>
                </div>
                
            </form>
        </section>
    </div>
    
    <?php } //End of else ?>    
    
    <?php
        include "php/footer.php";
    ?>

</body>
</html>
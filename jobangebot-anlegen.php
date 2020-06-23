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
                <section>
                    <h3 class="center">Allgemeine Informationen</h3>
                    <h4 class="center mb-4">Informationen zum Job</h4>

                    <div class="row">
                        <div class="col-md-5 last_td">
                            <select class="form-control" name="art" size="1" required>
                                <option value="">Beschäftigungsart</option>
                                <option value="Festanstellung">Festanstellung</option>
                                <option value="Praktikum">Praktikum</option>
                                <option value="Aushilfe">Aushilfe</option>
                                <option value="Werkstudent">Werkstudent</option>
                                <option value="Volontarioat">Volontarioat</option>
                                <option value="Minijob">Minijob</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label> Jobbezeichnung:
                                <input type="text" name="bez" maxlength="50" value="<?php if($job_found === true) echo($bez); ?>" placeholder="Jobbezeichnung" required>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 last_td">
                            <select class="form-control" name="fachrichtung" size="1" required>
                                <option value="">Fachrichtung auswählen</option>
                                <option value="Bildungs- und Sozialwissenschaften">Bildungs- und Sozialwissenschaften</option>
                                <option value="Informatik, Wirtschafts- und Rechtswissenschaften">Informatik, Wirtschafts- und Rechtswissenschaften</option>
                                <option value="Sprach- und Kulturwissenschaften">Sprach- und Kulturwissenschaften</option>
                                <option value="Human- und Gesellschaftswissenschaften">Human- und Gesellschaftswissenschaften</option>
                                <option value="Mathematik und Naturwissenschaften">Mathematik und Naturwissenschaften</option>
                                <option value="Medizin und Gesundheitswissenschaften">Medizin und Gesundheitswissenschaften</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                        </div>
                        <div class="col-lg-5 last_td">
                            <label>
                                <!--später min=(heute)-->
                                Frühster Beginn der Beschäftigung:
                                <input type="date" name="jdate" value="" required>
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
                                        <input type="checkbox" name="teilzeit" value="Teilzeit"> Teilzeit
                                    </label>
                                </div>
                                <div class="col-xl-4 col-6">
                                    <label>                                        
                                        <input type="checkbox" name="vollzeit" value="Vollzeit"> Vollzeit
                                    </label>
                                </div>
                                <div class="col-xl-4 col-12">
                                    <label>                                        
                                        <input type="checkbox" name="20h" value="20h"> &lt;20h/Woche
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label title="Geben Sie hier einen Link zu Ihrem firmeneigenen Bewerbungsportal ein">
                                Link zur direkten Bewerbung (optional): <input type="text" name="blink" maxlength="50" value="">
                            </label>
                        </div>
                    </div>

                <!--Inhaltsreduzierung
                    <div class="row">
                        <div class="col-12">
                            <h6>Falls Arbeitstelle nicht der Hauptfirmensitz (optional): </h6>
                        </div>
                        !--später vllt. erstmal ausgeblendet und erst nach klick eingeblendet?--
                        <div class="col-md-5 last_td">
                            <label>
                                Adresse der Arbeitsstelle:
                                <input type="text" name="aadr" value="">
                            </label>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5 last_td">
                            <label>
                                PLZ der Arbeitsstelle:
                                <input type="text" name="aplz" maxlength="5" value="">
                            </label>
                        </div>
                    </div>
                -->

                    <h4 class="center">Informationen zum Unternehmen</h4>

                    <div class="row">
                        <div class="col-md-12 center">
                            Firma: ABC GmbH
                        </div>
                        <div class="col-md-12 center last_td">
                            Hauptsitz: ABC Straße 123, 55555 Ort
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
                            <label>
                                <input type="checkbox" name="abachelor" value="bachelor"> Bachelor
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="amaster" value="master"> Master
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="ibachelor" value="ibachelor"> Im Bachelor immatrikuliert
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label>
                                <input type="checkbox" name="imaster" value="ibachelor"> Im Master immatrikuliert
                            </label>
                        </div>
                        <div class="col-xl-4 col-md-6 last_td">
                            <label>
                                <input type="checkbox" name="ausbildung" value="ausbildung"> Zus. berufliche Ausbildung
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
                             <textarea class="form-control" name="message" rows="10" cols="100"></textarea>                        
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
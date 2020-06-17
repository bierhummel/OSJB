<?php 
include('php/calc-job.php'); 

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
    <link rel="stylesheet" type="text/css" href="css/hamburger.css">

    <title>OSJB - Suchergebnisse</title>
</head>

<body>
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
    

    <div class="container suchergebnisse">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 m-0 p-0">
                <!--Hamburger nach Vorlage von https://www.mediaevent.de/tutorial/css-transform.html (Leicht angepasst)-->
                <input type="checkbox" id="hamburg">
                <section id="hamburger-menü" class="center">
                    <label for="hamburg" class="hamburg">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </label>
                </section>
                <!--Ende Vorlage-->

                <aside class="border adiv mb-4">
                    <fieldset>
                        <header>
                            <h3 class="center">Filteroptionen</h3>
                            <p class="center">(Noch in Bearbeitung)</p>
                            
                        </header>

                        <section>
                            <h4>Zeitintesität</h4>
                            <div>
                                <input type="checkbox" name="time[]" id="Vollzeit">
                                <label for="Vollzeit"> Vollzeit </label>
                            </div>
                            <div>
                                <input type="checkbox" name="time[]" id="Teilzeit">
                                <label for="Teilzeit">Teilzeit</label>
                            </div>
                            <div class="mb-2">
                                <input type="checkbox" name="time[]" id="20h">
                                <label for="20h">max. 20h/Woche</label>
                            </div>
                            <!--für .js: 
                                $('input[type="checkbox"]').on('change', function() {
                                    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
                                });
                                Damit nur eine Checkbox geklickt werden kann.
                            -->

                            <h4>Beschäftigungsart</h4>
                            <div>
                                <input type="checkbox" name="empl[]" id="Werkstudent">
                                <label for="Werkstudent">Werkstudent</label>
                            </div>
                            <div>
                                <input type="checkbox" name="empl[]" id="Minijob">
                                <label for="Minijob">Minijob</label>
                            </div>
                            <div>
                                <input type="checkbox" name="empl[]" id="Praktikum">
                                <label for="Praktikum">Praktikum</label>

                            </div>
                            <div>
                                <input type="checkbox" name="empl[]" id="Festanstellung">
                                <label for="Festanstellung">Festanstellung</label>

                            </div>
                            <div>
                                <input type="checkbox" name="empl[]" id="Aushilfe">
                                <label for="Aushilfe">Aushilfe</label>

                            </div>
                            <div class="mb-2">
                                <input type="checkbox" name="empl[]" id="Volontariat">
                                <label for="Volontariat">Volontariat</label>
                            </div>

                            <h4>Anzeigenalter</h4>
                            <div>
                                <input type="checkbox" name="age[]" id="Neueste">
                                <label for="Neueste">Neueste</label>

                            </div>
                            <div>
                                <input type="checkbox" name="age[]" id="3Tage">
                                <label for="3Tage">Älter als 3 Tage</label>

                            </div>
                            <div class="mb-2">
                                <input type="checkbox" name="age[]" id="Woche">
                                <label for="Woche"> Älter als eine Woche</label>
                            </div>

                            <h4>Benötigte Qualifikationen</h4>
                            <div>
                                <input type="checkbox" name="qualification[]" id="aB">
                                <label for="aB">Abgeschlossener B.Sc/B.A</label>

                            </div>
                            <div>
                                <input type="checkbox" name="qualification[]" id="aM">
                                <label for="aM">Abgeschlossener M.Sc/M.A</label>

                            </div>
                            <div>
                                <input type="checkbox" name="qualification[]" id="iB">
                                <label for="iB">Im Bachelor immatrikuliert</label>

                            </div>
                            <div>
                                <input type="checkbox" name="qualification[]" id="iM">
                                <label for="iM">Im Master immatrikuliert </label>

                            </div>
                            <div class="mb-2">
                                <input type="checkbox" name="qualification[]" id="Ausbildung">
                                <label for="Ausbildung">Zus. berufliche Ausbildung</label>
                            </div>

                            <h4>Weiteres</h4>
                            <div class="mb-3">
                                <label for="Modulliste">Module: </label>
                                <input class="form-control" list="Module" id="Modulliste">
                                <datalist id="Module">
                                    <option value="Internettechnologien">
                                    <option value="Rechnernetze 1">
                                    <option value="Buchhaltung und Abschluss">
                                </datalist>
                            </div>
                            <!--Falls möglich eine Liste aller Module der Uni Oldenburg einbinden-->

                            <div class="mb-3">
                                <label for="Fähigkeitenliste">Besondere Fähigkeiten und Kenntnisse: </label>
                                <input class="form-control" list="Fähigkeiten" id="Fähigkeitenliste">
                                <datalist id="Fähigkeiten">
                                    <option value="Progammierung Java">
                                    <option value="Webprogrammierung">
                                    <option value="Zehnfingerschreiben">
                                </datalist>
                            </div>

                            <div class="mb-3">
                                <label for="Datum">Frühster Beginn der Beschäftigung</label>
                                <input class="form-control" id="Datum" type="date" name="jdate" value="" required>
                            </div>
                            <!--später min=(heute)-->

                            <div class="mb-4">
                                <label for="Umkreis">Umkreis ändern</label>
                                <select class="form-control" id="Umkreis" name="umkreis" size="1" required>
                                    <option value="">Umkreis auswählen</option>
                                    <option value="5">5 km</option>
                                    <option value="10">10 km</option>
                                    <option value="15">15 km</option>
                                    <option value="20">20 km</option>
                                    <option value="25">25 km</option>
                                    <option value="30">30 km</option>
                                    <option value="50+">50+ km</option>
                                </select>
                            </div>
                        </section>
                    </fieldset>
                </aside>
            </div>

            <div class="col-sm-6 col-md-8 col-lg-9">
                
            <?php 
                $count = 0;
                foreach($jobs as $job): 
                    extract($job);
                    $count++;
            ?>
                                
                <section class="border mb-4">
                    <div class="row">
                        <div class="col-md-5 col-lg-4 col-xl-3 center align-self-center mb-3">
                            <img class="img-fluid" src="bilder/logo.png" alt="muster_firmenlogo" width="150" height="150">
                        </div>
                        <div class="col-md-7 col-lg-8 col-xl-9">
                            <h5><?php echo($art); ?> - <?php echo($bez); ?></h5>
                            <p>20h/Woche</p>
                            <p>Kurze Informationen zur Anzeige</p>
                            <p class="end">
                                <a class="btn btn-primary" href="jobangebot-anzeigen.php?id=<?php echo($id)?>">Weitere Informationen</a>
                            </p>
                        </div>
                    </div>
                </section>
                
            <?php endforeach; ?>
                
                <p class="center">Ende der Liste. Es wurden <?php echo $count ?> Jobangebote gefunden.</p>
            </div>
        </div>
    </div>

    <?php
        include "php/footer.php";
    ?>
</body>

</html>
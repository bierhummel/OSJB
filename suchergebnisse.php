<?php 
ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();

include('php/process-jobDAO.php'); 

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
    
    <script src="javascript/check-userinputs.js" async></script>
    <script src="javascript/dynamische-suchfilter.js" async></script>

    <title>OSJB - Suchergebnisse</title>
</head>

<body>
    <?php
        $title = "OSJB";
        include "php/header.php";
    ?>
  <div id = "content">   

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
                            <h3 class="center mb-3">Filteroptionen</h3>
                        </header>

                        <section>
                            <form name="filter" action="" method="get">
                                
                                <!--Jobbezeichnung-->
                                <!--Problem: Bei Enter wird automatisch erster Suchvorschlag ausgewählt und nicht das was im Eingabefeld steht...-->
                                <div class="mb-2">
                                    <h5><label class="mb-0" for="bez">Jobbezeichnung</label></h5>
                                    <input type="text" id="bez" name="bez" class="form-control" placeholder="Jobbezeichnung" value="<?php if( isset($request_checked["bez"]) ) echo $request_checked["bez"] ?>">
                                    <p>Vorschläge: <span id="tipps"></span></p>
                                </div>
                                
                                <!--PLZ-->
                                <div class="mb-2">
                                    <h5><label class="mb-0" for="plz">PLZ</label></h5>
                                    <input type="text" id="plz" name="plz" class="form-control" maxlength="5" placeholder="Deine PLZ" required value="<?php if( isset($request_checked["plz"]) ) echo $request_checked["plz"] ?>">
                                </div>

                                <!--Umkreis-->
                                <div class="mb-2">
                                    <h5><label class="mb-0" for="Umkreis">Umkreis</label></h5>
                                    <select class="form-control" id="Umkreis" name="umkreis" size="1" required>
                                        <option value="">Umkreis auswählen</option>
                                        <option value="5" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "5") echo("selected") ?> >
                                            5 km
                                        </option>
                                        <option value="10" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "10") echo("selected") ?> >
                                            10 km
                                        </option>
                                        <option value="15" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "15") echo("selected") ?> >
                                            15 km
                                        </option>
                                        <option value="20" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "20") echo("selected") ?> >
                                            20 km
                                        </option>
                                        <option value="25" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "25") echo("selected") ?> >
                                            25 km
                                        </option>
                                        <option value="30" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "30") echo("selected") ?> >
                                            30 km
                                        </option>
                                        <option value="50+" <?php if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] == "50+") echo("selected") ?> >
                                            50+ km
                                        </option>
                                    </select>
                                </div>
                                
                                <!--Fachrichtung-->
                                <div class="mb-2">
                                    <h5><label class="mb-0" for="fachrichtung">Fachrichtung</label></h5>
                                    <select class="form-control" name="fachrichtung" size="1">
                                        <option value="">Fachrichtung auswählen</option>
                                        <option value="Bildungs- und Sozialwissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Bildungs- und Sozialwissenschaften"){ ?> selected <?php } ?> >
                                            Bildungs- und Sozialwissenschaften
                                        </option>
                                        <option value="Informatik, Wirtschafts- und Rechtswissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Informatik, Wirtschafts- und Rechtswissenschaften"){ ?> selected <?php } ?> >
                                            Informatik, Wirtschafts- und Rechtswissenschaften
                                        </option>
                                        <option value="Sprach- und Kulturwissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Sprach- und Kulturwissenschaften"){ ?> selected <?php } ?> >
                                            Sprach- und Kulturwissenschaften
                                        </option>
                                        <option value="Human- und Gesellschaftswissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Human- und Gesellschaftswissenschaften"){ ?> selected <?php } ?> >
                                            Human- und Gesellschaftswissenschaften
                                        </option>
                                        <option value="Mathematik und Naturwissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Mathematik und Naturwissenschaften"){ ?> selected <?php } ?> >
                                            Mathematik und Naturwissenschaften
                                        </option>
                                        <option value="Medizin und Gesundheitswissenschaften" <?php if(isset($request_checked["fachrichtung"]) && $request_checked["fachrichtung"] == "Medizin und Gesundheitswissenschaften"){ ?> selected <?php } ?> >
                                            Medizin und Gesundheitswissenschaften
                                        </option>
                                    </select>
                                </div>
                                
                                <!--Beginn-->
                                <div class="mb-3">
                                    <h5><label class="mb-0" for="Datum">Frühster Beginn</label></h5>
                                    <input class="form-control" id="Datum" type="date" name="Datum" value="<?php if( isset($request_checked["Datum"]) ) echo $request_checked["Datum"] ?>">
                                </div>
                                

                                <!--Inhaltsreduzierung-->
                                <!--
                                <h5>Anzeigenalter</h5>
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
                                -->

                                <!--Beschäftigungsart-->
                                <h5>Beschäftigungsart</h5>
                                <div>
                                    <input type="checkbox" name="Werkstudent" id="Werkstudent" <?php if( isset($request_checked["Werkstudent"]) && $request_checked["Werkstudent"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Werkstudent">Werkstudent</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="Minijob" id="Minijob" <?php if( isset($request_checked["Minijob"]) && $request_checked["Minijob"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Minijob">Minijob</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="Praktikum" id="Praktikum" <?php if( isset($request_checked["Praktikum"]) && $request_checked["Praktikum"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Praktikum">Praktikum</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="Festanstellung" id="Festanstellung" <?php if( isset($request_checked["Festanstellung"]) && $request_checked["Festanstellung"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Festanstellung">Festanstellung</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="Aushilfe" id="Aushilfe" <?php if( isset($request_checked["Aushilfe"]) && $request_checked["Aushilfe"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Aushilfe">Aushilfe</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="Volontariat" id="Volontariat" <?php if( isset($request_checked["Volontariat"]) && $request_checked["Volontariat"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Volontariat">Volontariat</label>
                                </div>
                                
                                <!--Zeitintesität-->
                                <h5>Zeitintesität</h5>
                                <div>
                                    <input type="checkbox" name="Vollzeit" id="Vollzeit"  <?php if( isset($request_checked["Vollzeit"]) && $request_checked["Vollzeit"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Vollzeit"> Vollzeit </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="Teilzeit" id="Teilzeit" <?php if( isset($request_checked["Teilzeit"]) && $request_checked["Teilzeit"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Teilzeit">Teilzeit</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="20h" id="20h" <?php if( isset($request_checked["20h"]) && $request_checked["20h"] == "on"){ ?> checked <?php } ?> >
                                    <label for="20h">max. 20h/Woche</label>
                                </div>
                                
                                <!--Qualifikationen-->
                                <h5>Benötigte Qualifikationen</h5>
                                <div>
                                    <input type="checkbox" name="aB" id="aB"  <?php if( isset($request_checked["aB"]) && $request_checked["aB"] == "on"){ ?> checked <?php } ?> >
                                    <label for="aB">Abgeschlossener B.Sc/B.A</label>

                                </div>
                                <div>
                                    <input type="checkbox" name="aM" id="aM" <?php if( isset($request_checked["aM"]) && $request_checked["aM"] == "on"){ ?> checked <?php } ?> >
                                    <label for="aM">Abgeschlossener M.Sc/M.A</label>

                                </div>
                                <div>
                                    <input type="checkbox" name="iB" id="iB" <?php if( isset($request_checked["iB"]) && $request_checked["iB"] == "on"){ ?> checked <?php } ?> >
                                    <label for="iB">Im Bachelor immatrikuliert</label>

                                </div>
                                <div>
                                    <input type="checkbox" name="iM" id="iM" <?php if( isset($request_checked["iM"]) && $request_checked["iM"] == "on"){ ?> checked <?php } ?> >
                                    <label for="iM">Im Master immatrikuliert </label>

                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="Ausbildung" id="Ausbildung" <?php if( isset($request_checked["Ausbildung"]) && $request_checked["Ausbildung"] == "on"){ ?> checked <?php } ?> >
                                    <label for="Ausbildung">Zus. berufliche Ausbildung</label>
                                </div>
                                
                                <!--Inhaltsreduzierung da nur zu 2.-->
                                <!--
                                <h5>Weiteres</h5>
                                <div class="mb-3">
                                    <label for="Modulliste">Module: </label>
                                    <input class="form-control" list="Module" id="Modulliste">
                                    <datalist id="Module">
                                        <option value="Internettechnologien">
                                        <option value="Rechnernetze 1">
                                        <option value="Buchhaltung und Abschluss">
                                    </datalist>
                                </div>-->
                                <!--Falls möglich eine Liste aller Module der Uni Oldenburg einbinden-->
                                
                                <!--
                                <div class="mb-3">
                                    <label for="Fähigkeitenliste">Besondere Fähigkeiten und Kenntnisse: </label>
                                    <input class="form-control" list="Fähigkeiten" id="Fähigkeitenliste">
                                    <datalist id="Fähigkeiten">
                                        <option value="Progammierung Java">
                                        <option value="Webprogrammierung">
                                        <option value="Zehnfingerschreiben">
                                    </datalist>
                                </div>
                                -->

                                <!--Submit nur anzeigen wenn JS deaktiviert-->
                                <!--<noscript>-->
                                    <div class="mt-2 mb-3">
                                         <input type="submit" id="submit_filter" value="Filter anwenden" class="btn btn-primary">
                                    </div>
                                <!--</noscript>-->
                                
                            </form>
                        </section>
                    </fieldset>
                </aside>
            </div>

            <!--Div das die gefunden Jobangebote enthält-->
            <div class="col-sm-6 col-md-8 col-lg-9">
                
            <?php
                //In der DB gefundene Jobangebote einzeln durchlaufen, falls welche gefunden
                $count = 0;
                if($jobs != null){ 
                    foreach($jobs as $job): 
                        extract($job);
                        $count++;
            ?>
                
                <!--Einzelnes Jobangebot-->                
                <section class="border mb-4 mt-3">
                    <div class="row">
                        <div class="col-md-5 col-lg-4 col-xl-3 center align-self-center mb-3">
                            <?php
                                if( isset($logo) ){
                            ?>
                                    <img class="img-fluid" src="<?= $logo ?>" alt="Firmenlogo" width="150" height="150">
                            <?php
                                } else {
                            ?>
                                    <img class="img-fluid" src="bilder/logo.png" alt="Muster-Firmenlogo" width="150" height="150">
                            <?php 
                                }
                            ?>
                        </div>
                        <div class="col-md-7 col-lg-8 col-xl-9">
                            <h5> <?php echo($art); ?> - <?php echo($titel); ?> </h5>
                            <p> <?=$zeitintensitaet?> </p>
                            <p> 
                                <?php 
                                    echo substr($beschreibung, 0, 150); 
                                    if (strlen($beschreibung) > 150){echo " (...)";} 
                                ?> 
                            </p>
                            <p class="end">
                                <a class="btn btn-primary" href="jobangebot-anzeigen.php?id=<?php echo($id)?>">Weitere Informationen</a>
                            </p>
                        </div>
                    </div>
                </section>
                
            <?php endforeach; } ?>
                
                <p class="center">Ende der Liste. Es wurde(n) <?php echo $count ?> Jobangebot(e) gefunden.</p>
            </div>
        </div>
    </div>
    </div>
    <?php
        include "php/footer.php";
    ?>
</body>

</html>
<?php

//Datei nach merge umbennen zu process-job?


//Überprüfung der übergebenen Eingabedaten zum Schutz vor XSS, egal ob GET oder POST
    include('check-inputs.php'); 
    $request_checked = check_inputs($_REQUEST);



//Geschäftslogik der Verarbeitung von Jobangeboten
    
    //Wenn noch keine Session gestartet, Session starten (Wichtig da teilweise von Formularen direkt aufgerufen, teilweise als include in View enthalten)
    if(session_status() != 2){
        //session starten
        ini_set( 'session.use_cookies', 1 );
        ini_set( 'session.use_only_cookies', 0 );
        ini_set( 'session.use_trans_sid', 1 );
        session_start();  
    }

    //Einbindung des DAO
    include('dao-job.php'); 
    $JobDAO = new SQLiteJobDAO();

    
    //Einbindung von Funktionen zum Umgang mit der GoogleMapsAPI
    include('helper-mapsAPI.php');

    //Variable für (ggf. zweidimensionales) Array mit gefundenen Jobangeboten vorbereiten
    $jobs = null;


    
    //Liste der Jobs eines Users laden
    if(basename($_SERVER['PHP_SELF']) == "profil.php"){
        $jobs = $JobDAO->loadJobsOfUser($_SESSION["mail"]);  
    }

    //Einzelnes Jobangebot laden
    if( ( basename($_SERVER['PHP_SELF']) == "jobangebot-anlegen.php" && isset($request_checked["id"]) ) || basename($_SERVER['PHP_SELF']) == "jobangebot-anzeigen.php" ){
        $jobs = $JobDAO->loadJob($request_checked["id"]); 
        if($jobs != null){
            extract($jobs);
        }
    }

    //Jobs entsprechend der Suchkriterien der Inputfelder laden
    if( basename($_SERVER['PHP_SELF']) == "suchergebnisse.php" && isset ($request_checked["plz"]) ){
        //Jobangebote entsprechend der Suchkriterien von DAO auslesen lassen
        $jobs = $JobDAO->loadJobs($request_checked); 
        
        //Wenn der Umkreis eingeschränkt wurde
        if( isset ($request_checked["umkreis"]) && $request_checked["umkreis"] != "50+") {
            //Entfernung zur angegeben PLZ ermitteln und alles außerhalb des Umkreises aussortieren
            $jobs = getJobsNearby($request_checked["umkreis"], $request_checked["plz"], $jobs);
        }
        extract($jobs);
    }

    //AJAX Suche nach Jobbezeichnungen 
    if( isset($request_checked["suche"]) ){
        //Rückgabearray abspeichern
        $vorschläge = ($JobDAO->searchJobbez($request_checked["input"]));
        if($vorschläge == null){ 
            echo "Keine Jobangebote gefunden.";
        }
        else{
            foreach($vorschläge as $vorschlag){
                echo ('<button class="btn btn-primary mb-1 vorschlag">' . $vorschlag["titel"] . '</button >'); 
            } 
        }
    }

    //Anlegen neuer Jobangebote
    if(isset($request_checked["erstellen"]) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {
         
        //Koordinaten des Jobangebotes ermitteln
        $coordinates = getCoordinates($request_checked, 1);
        $job_data = $request_checked;
        $job_data["coordinates"] = $coordinates;

        //Daten den zu erstellenden Jobangebots zusammen mit der Mail des Nutzers an DAO übergeben
        $jobs = $JobDAO->createJob($job_data, $_SESSION["mail"]);

        //Erstelltes Jobangebot anzeigen
        header( 'location: ../jobangebot-anzeigen.php?id=' . $jobs["id"]);
        exit;
    }   
    
    //Bearbeiten von Jobangeboten
    if(isset($request_checked["bearbeiten"]) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {
        
        //Koordinaten des Jobangebotes ermitteln
        $coordinates = getCoordinates($request_checked, 1);
        $job_data = $request_checked;
        $job_data["coordinates"] = $coordinates;

        //Übergangslösung, wird geändert wenn aufruf von Bearbeiten über Post statt get
        $job_id = $JobDAO->updateJob($job_data, $request_checked["update_id"]);
         
        header( 'location: ../jobangebot-anzeigen.php?id=' . $job_id);
        exit;
     }


    //Löschen (aktuell noch über get.. wird noch geändert)
    if( isset( $request_checked["del"] ) && $request_checked["del"] === "1" && isset( $request_checked["id"] ) && isset( $_SESSION["eingeloggt"] ) && $_SESSION["eingeloggt"] == "true" )
    {
        $JobDAO->deleteJob($request_checked["id"]);
        $jobs = $JobDAO->loadJobsOfUser($_SESSION["mail"]); 
    }



//Erzeugung von Ausgabedaten?



//Unerlaubter oder fehlerhafter Aufruf?


?>

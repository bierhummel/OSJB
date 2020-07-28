<?php

//Datei umbennen zu process-job?


//Überprüfung der übergebenen Eingabedaten zum Schutz vor XSS, egal ob GET oder POST
    include('check-inputs.php'); 
    $request_checked = check_inputs($_REQUEST);

//Initialisierungen und Includes
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

//Aufgaben, für die diese Datei direkt aufgerufen wird:
    //Anlegen neuer Jobangebote
    if( isset($request_checked["erstellen"]) && isset($_SESSION["eingeloggt"]) && isset($request_checked["csrf_token"]) && $request_checked['csrf_token'] == $_SESSION["csrf_token"] ) {
         
        //Koordinaten des Standord des Jobangebotes ermitteln
        $coordinates = getCoordinates($request_checked, 1);
        $job_data = $request_checked;
        $job_data["coordinates"] = $coordinates;

        //Daten des zu erstellenden Jobangebots zusammen mit der Mail des Nutzers an DAO übergeben
        $jobs = $JobDAO->createJob($job_data, $_SESSION["mail"]);

        //Erstelltes Jobangebot anzeigen
        header( 'location: ../jobangebot-anzeigen.php?id=' . $jobs["id"]);
        exit;
    }   
    
    //Bearbeiten von Jobangeboten
    if( isset($request_checked["bearbeiten"]) && isset($_SESSION["eingeloggt"]) && isset($request_checked["csrf_token"]) && $request_checked['csrf_token'] == $_SESSION["csrf_token"] && isset($request_checked["id"]) ) {
        
        //Koordinaten des Jobangebotes ermitteln
        $coordinates = getCoordinates($request_checked, 1);
        $job_data = $request_checked;
        $job_data["coordinates"] = $coordinates;

        //Daten des zu erstellenden Jobangebots zusammen mit der Mail des aktiven Nutzers und der Job-ID an DAO übergeben
        $result = $JobDAO->updateJob($job_data, $request_checked["id"], $_SESSION["mail"]);

        //Update erfolgreich: Zeige das überarbeitete Jobangebot.
        if( $result === true) {
            //Bearbeitetes Jobangebot anzeigen
            header( 'location: ../jobangebot-anzeigen.php?id=' . $request_checked["id"]);
            exit;
        }
        //Sonst speichere die Fehlermeldung und rufe Profil auf, wo Fehlermeldung angezeigt wird.
        else{
            $_SESSION["UpdateError"] = $result;
            header( 'location: ../profil.php');
            exit;
        }
        
     }

    //Löschen von Jobangeboten
    if( isset($request_checked["del"]) && isset($_SESSION["eingeloggt"]) && isset($request_checked["csrf_token"]) && $request_checked['csrf_token'] == $_SESSION["csrf_token"] && isset($request_checked["id"]) )
    {
        //ID des zu löschenden Jobs und die Mail des aktiven Nutzers übergeben
        $result = $JobDAO->deleteJob($request_checked["id"], $_SESSION["mail"]);
        
     if( ! ($result === true) ) {
         $_SESSION["DeleteError"] = $result;
     }
        header( 'location: ../profil.php');
        exit;
    }


//Aufgaben für die diese Datei als include in der View enthalten ist:
    //Jobs entsprechend der Suchkriterien der Inputfelder laden
    if( basename($_SERVER['PHP_SELF']) == "suchergebnisse.php" && isset($request_checked["plz"]) ){
        //Jobangebote entsprechend der Suchkriterien von DAO auslesen lassen
        $jobs = $JobDAO->loadJobs($request_checked); 
        
        //Wenn der Umkreis eingeschränkt wurde
        if( isset($request_checked["umkreis"]) && $request_checked["umkreis"] != "50+" ) {
            //Entfernung zur angegeben PLZ ermitteln und alles außerhalb des Umkreises aussortieren
            $jobs = getJobsNearby($request_checked["umkreis"], $request_checked["plz"], $jobs);
        }
        //extract($jobs);
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

    //Einzelnes Jobangebot laden zum Anzeigen
    if( basename($_SERVER['PHP_SELF']) == "jobangebot-anzeigen.php" && isset($request_checked["id"]) ){
        $jobs = $JobDAO->loadJob($request_checked["id"]); 
        if($jobs != null){
            extract($jobs);
        }
    }
    
    //Liste der Jobs eines Users laden
    if( basename($_SERVER['PHP_SELF']) == "profil.php" && isset($_SESSION["eingeloggt"]) ){
        $jobs = $JobDAO->loadJobsOfUser($_SESSION["mail"]);
    }


    //Einzelnes Jobangebot laden zum Bearbeiten
    if( basename($_SERVER['PHP_SELF']) == "jobangebot-anlegen.php" && isset($request_checked["id"]) && isset($_SESSION["eingeloggt"]) ) {
        
        //Sicherstellen, dass dieses Jobangebot auch zu diesem User gehört
        $temp_jobsOfUser = $JobDAO->loadJobsOfUser($_SESSION["mail"]);
        foreach ($temp_jobsOfUser as $temp_jobOfUser) {
            if($temp_jobOfUser["id"] == $request_checked["id"]){
                
                //Jobangebot gehört User: Job extracten
                $jobs = $temp_jobOfUser;
                extract($jobs);
            }
        }
    }





//Erzeugung von Ausgabedaten?



//Unerlaubter oder fehlerhafter Aufruf?


?>

<?php

//Datei nach merge umbennen zu process-job?

//Überprüfung der Eingabedaten
    include('check-inputs.php'); 
    /*$get_checked = check_get($_GET);
    $post_checked = check_get($_POST);*/
    $request_checked = check_inputs($_REQUEST);

    

//Geschäftslogik der Verwaltung von Jobangeboten
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


    //Variable mit allen anzuzeigenden Jobangeboten füllen (nicht optimal, wird überarbeitet)
    //$jobs = $JobDAO->loadJobs($request_checked);   

    
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

    //Jobs entsprechend der Suchkriteren der Inputfelder laden
    if( basename($_SERVER['PHP_SELF']) == "suchergebnisse.php"){
        $jobs = $JobDAO->loadJobs($request_checked); 
        extract($jobs);
    }



    //Auswertung der Filteroptionen (fehlt noch)
    



    //Anlegen neuer Jobangebote
     if(isset($request_checked["erstellen"]) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {
         $jobs = $JobDAO->createJob($request_checked, $_SESSION["mail"]);
         
         header( 'location: ../jobangebot-anzeigen.php?id=' . $jobs["id"]);
         exit;
     }

    
    //Bearbeiten von Jobangeboten
    if(isset($request_checked["bearbeiten"]) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {
        $jobs = $JobDAO->updateJob($request_checked);
         
        header( 'location: ../jobangebot-anzeigen?id=.php' . $jobs["id"]);
        exit;
     }


    //Löschen
    if(isset($request_checked["del"]) && is_string($request_checked["del"]) && $request_checked["del"] === "1" && isset($request_checked["id"]) && is_string($request_checked["id"]) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ){
        $jobs = $JobDAO->deleteJob($request_checked["id"]);
    }



//Erzeugung von Ausgabedaten



//Unerlaubter oder fehlerhafter Aufruf?


?>

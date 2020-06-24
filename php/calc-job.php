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
        
        //Übergangslösung, wird geändert wenn aufruf von Bearbeiten über Post statt get
        $job_id = $JobDAO->updateJob($request_checked, $request_checked["update_id"]);
        
        var_dump( $job_id);

        
         
        header( 'location: ../jobangebot-anzeigen.php?id=' . $job_id);
        exit;
     }


    //Löschen (aktuell noch über get.. wird noch geändert)
    if( isset( $request_checked["del"] ) && $request_checked["del"] === "1" && isset( $request_checked["id"] ) && isset( $_SESSION["eingeloggt"] ) && $_SESSION["eingeloggt"] == "true" )
    {
        $JobDAO->deleteJob($request_checked["id"]);
        $jobs = $JobDAO->loadJobsOfUser($_SESSION["mail"]); 
    }



//Erzeugung von Ausgabedaten



//Unerlaubter oder fehlerhafter Aufruf?


?>

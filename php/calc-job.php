<?php

//Überprüfung der Eingabedaten
    include('check-inputs.php'); 
    /*$get_checked = check_get($_GET);
    $post_checked = check_get($_POST);*/
    $request_checked = check_inputs($_REQUEST);

    

//Geschäftslogik

    //Einbindung des DAO
    include('dao-job.php'); 
    $JobDAO = new DummyJobDAO();


    //Variable mit allen anzuzeigenden Jobangeboten füllen
    $jobs = $JobDAO->loadJobs($request_checked);   

    //Auswertung der Filteroptionen
    
    //falls ID gesetzt -> jobangebot-bearbeiten oder jobangebot-anzeigen
    $id_set = false;
    if(isset($request_checked["id"]) && is_string($request_checked["id"])){
        $id_set = true;
    }


    //Anlegen neuer Jobangebote
     if(isset($request_checked["submit_n_job"]) && is_string($request_checked["submit_n_job"]) && $request_checked["submit_n_job"] === "Jobanzeige erstellen"){
         $jobs = $JobDAO->saveJob($request_checked);
         $id_set = true;         
     }


    //Löschen (provisorisch über get -> bessere Lösung folgt)
    if(isset($request_checked["del"]) && is_string($request_checked["del"]) && $request_checked["del"] === "1" && isset($request_checked["id"]) && is_string($request_checked["id"])){
        $jobs = $JobDAO->deleteJob($request_checked["id"]);
    }



//Erzeugung von Ausgabedaten
    

    //wird nach job id gesucht und existiert dieser job?
    $job_found = false;
    if($id_set === true && isset(array_values($jobs)[0]["id"])){
        $job_found = true; 
        extract(array_values($jobs)[0]);
    }


?>

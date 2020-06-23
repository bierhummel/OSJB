<?php

//Orientiert an Vorlage von http://best-practice-software-engineering.ifs.tuwien.ac.at/patterns/dao.html

interface JobDAO {
    public function createJob($job, $user_email);
    public function updateJob($job);
    public function loadJobs($suchkrit);
    public function deleteJob($job_id);
}

/* Klasse für Zugriff auf Jobs in DB*/
class SQLiteJobDAO implements JobDAO {

    //erhält array mit inputwerten von jobangebot-anlegen.php und gibt true/false zurück
    public function createJob($job, $user_email){
    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $user = null; //Array mit allen wichtigen Informationen des Users (z.b. keine id kein PW)

        try{
            // Default: Anzeige ist aktiv
            $status = 1;
            //TODO: Titel, Strasse, Hausnummer, PLZ und Stadt werden noch nicht abgefragt
            $titel = NULL;
            $strasse = NULL;
            $hausnr = NULL;
            $plz = NULL;
            $stadt = NULL;
            //ID aus der DB holen
            $id = "select id from user where mail = :mail";
            $stmt = $db->prepare($id);
            $stmt->bindParam(':mail', $user_email);  
            $stmt->execute();
            $id = $stmt->fetchColumn();
            //Beschäftigungsart
            $beschaeftigungsart = $job['art'];
            //Fachrichtung
            $fachrichtung = $job['fachrichtung'];
            //Zeitintesität
            $intensitaet = '';
            if($job['teilzeit'] == 'Teilzeit'){
                $intensitaet = $job['teilzeit'];
            }
            elseif($job['vollzeit'] == 'Vollzeit'){
                $intensitaet = $job['vollzeit'];
            }
            else {
                $intensitaet = $job['20h'];
            }
            //Jobbezeichnung
            $jobbezeichnung = $job['bez'];
            //Frühester Beginn (Erstmal String, wird bei Refactoring der DB geändert)
            $beginn = $job['jdate'];
            //Link zur direkten Bewerbung 
            $link = $job['blink'];
            //Wenn kein Link vorhanden: Setze leeren String auf NULL für die DB
            if($link == ''){
                $link = NULL;
            }
            //Qualifikation (funkioniert nicht)
            $bachelor = 0;
            $im_bachelor = 0;
            $master = 0;
            $im_master = 0;
            $ausbildung = 0;
            if($job['abachelor'] == 'bachelor'){
                $bachelor = 1;
            }
            if($job['ibachelor'] == 'ibachelor'){
                $im_bachelor = 1;
            }
            if($job['amaster'] == 'master'){
                $master = 1;
            }
            if($job['imaster'] == 'imaster'){
                $im_master = 1;
            }
            if($job['ausbildung'] == 'ausbildung'){
                $ausbildung = 1;
            }
            //Individuelle Beschreibung
            $beschreibung = $job['message'];
            if ($beschreibung == ''){
                $beschreibung = NULL;
            }
            //SQL Insert
            $newJob = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn)";
            $stmt = $db->prepare($newJob);
            
            $stmt->bindParam(':uid', $id);  
            $stmt->bindParam(':status', $status);  
            $stmt->bindParam(':titel', $titel); // n.v.   
            $stmt->bindParam(':strasse', $strasse);  // n.v.      
            $stmt->bindParam(':hausnr', $hausnr); // n.v.   
            $stmt->bindParam(':plz', $plz); // n.v.   
            $stmt->bindParam(':stadt', $stadt); // n.v.     
            $stmt->bindParam(':beschreibung', $beschreibung); 
            $stmt->bindParam(':art', $beschaeftigungsart);   
            $stmt->bindParam(':im_bachelor', $im_bachelor); 
            $stmt->bindParam(':bachelor', $bachelor);
            $stmt->bindParam(':im_master', $im_master);    
            $stmt->bindParam(':master', $master);    
            $stmt->bindParam(':ausbildung', $ausbildung);
            $stmt->bindParam(':fachrichtung', $fachrichtung); 
            $stmt->bindParam(':link', $link);       
            $stmt->bindParam(':beschaeftigungsbeginn', $beginn);  
            $stmt->bindParam(':zeitintensitaet', $intensitaet);
            $stmt->execute();
            
            $new_job = array("status" => $status, "titel" => $titel, "strasse" => $strasse, "hausnr" => $hausnr, "plz" => $plz, "stadt" => $stadt, "beschreibung" => $beschreibung, "art" => $beschaeftigungsart, "ibachelor" => $im_bachelor, "bachelor" => $bachelor, "imaster" => $im_master, "master" => $master, "ausbildung" => $ausbildung, "fachrichtung" => $fachrichtung, "link" => $link, "beginn" => $beginn, "intensitaet" => $intensitaet);
   
            return new_job;
            
        } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }      
    }     
    
    //erhält array mit inputwerten von jobangebot-anlegen.php und gibt true/false zurück
    public function updateJob($job){
        //TODO: job_id muss noch mit übergeben werden. Übergangslösung:
       // $job_id = 4;
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $user = null; //Array mit allen wichtigen Informationen des Users (z.b. keine id kein PW)

        try{ 
            // Default: Anzeige ist aktiv TODO: Das soll vom User noch verändert werden können?
            $status = 1;
            //TODO: Titel, Strasse, Hausnummer, PLZ und Stadt werden noch nicht abgefragt
            $titel = NULL;
            $strasse = NULL;
            $hausnr = NULL;
            $plz = NULL;
            $stadt = NULL;
            
            //Beschäftigungsart
            $beschaeftigungsart = $job['art'];
            //Fachrichtung
            $fachrichtung = $job['fachrichtung'];
            //Zeitintesität
            $intensitaet = '';
            if($job['teilzeit'] == 'Teilzeit'){
                $intensitaet = $job['teilzeit'];
            }
            elseif($job['vollzeit'] == 'Vollzeit'){
                $intensitaet = $job['vollzeit'];
            }
            else {
                $intensitaet = $job['20h'];
            }
            //Jobbezeichnung
            $jobbezeichnung = $job['bez'];
            //Frühester Beginn (Erstmal String, wird bei Refactoring der DB geändert)
            $beginn = $job['jdate'];
            //Link zur direkten Bewerbung 
            $link = $job['blink'];
            //Wenn kein Link vorhanden: Setze leeren String auf NULL für die DB
            if($link == ''){
                $link = NULL;
            }
            //Qualifikation (funkioniert nicht)
            $bachelor = 0;
            $im_bachelor = 0;
            $master = 0;
            $im_master = 0;
            $ausbildung = 0;
            if($job['abachelor'] == 'bachelor'){
                $bachelor = 1;
            }
            if($job['ibachelor'] == 'ibachelor'){
                $im_bachelor = 1;
            }
            if($job['amaster'] == 'master'){
                $master = 1;
            }
            if($job['imaster'] == 'imaster'){
                $im_master = 1;
            }
            if($job['ausbildung'] == 'ausbildung'){
                $ausbildung = 1;
            }
            //Individuelle Beschreibung
            $beschreibung = $job['message'];
            if ($beschreibung == ''){
                $beschreibung = NULL;
            }
            //SQL Update        
            $updatedJob = "update jobangebot set status = :status, titel = :titel, strasse = :strasse, hausnr = :hausnr, plz = :plz, stadt = :stadt, beschreibung = :beschreibung, art = :art, zeitintensitaet = :zeitintensitaet, im_bachelor = :im_bachelor, bachelor = :bachelor, im_master = :im_master, master = :master, ausbildung = :ausbildung, fachrichtung = :fachrichtung, link = :link, beschaeftigungsbeginn = :beschaeftigungsbeginn";
            
            $stmt = $db->prepare($newJob);
            
            $stmt->bindParam(':status', $status);  
            $stmt->bindParam(':titel', $titel); // n.v.   
            $stmt->bindParam(':strasse', $strasse);  // n.v.      
            $stmt->bindParam(':hausnr', $hausnr); // n.v.   
            $stmt->bindParam(':plz', $plz); // n.v.   
            $stmt->bindParam(':stadt', $stadt); // n.v.     
            $stmt->bindParam(':beschreibung', $beschreibung); 
            $stmt->bindParam(':art', $beschaeftigungsart);   
            $stmt->bindParam(':im_bachelor', $im_bachelor); 
            $stmt->bindParam(':bachelor', $bachelor);
            $stmt->bindParam(':im_master', $im_master);    
            $stmt->bindParam(':master', $master);    
            $stmt->bindParam(':ausbildung', $ausbildung);
            $stmt->bindParam(':fachrichtung', $fachrichtung); 
            $stmt->bindParam(':link', $link);       
            $stmt->bindParam(':beschaeftigungsbeginn', $beginn);  
            $stmt->bindParam(':zeitintensitaet', $intensitaet);
            $stmt->execute();
            
            return true;
            
        } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }      
        return false;
    }     
    
    
    //erhält entweder array mit inputwerten von index (oder später von filterbox), die e-mail eines nutzers oder eine jobid und gibt zwei-dimensionales array mit den gefundenen jobangeboten als array zurück 
    public function loadJobs($suchkrit){
        
    }
    
    public function loadJobsOfUser($user_mail){
        
        
    }
    
    public function loadJob($job_id){
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        try{
            $stmt = $db->prepare("SELECT * FROM jobangebot WHERE id = ?");
            $job = $stmt->execute(array($job_id));   
            return $job;
}
     catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }    
    } 
        
        
    
    
    //erhält job_id und gibt true/false zurück
    public function deleteJob($job_id){
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

        try{
            $delJob = "delete from jobangebot where id = :id";
            $stmt = $db->prepare($delJob);
            $stmt->bindParam(':uid', $id);
            $stmt->execute();
            return true;
    } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }    
        return false;
    }     
}


/*
class DummyJobDAO implements JobDAO {
    
    private $jobs = array();
    private $max_id = 0;
    
    public function __construct() {
        $job1 = array("id" => 0, "bez" => "Test Job 1", "art" => "Werkstudent", "fachrichtung" => "fr1");       
        $this->max_id++;
        $job2 = array("id" => 1, "bez" => "Test Job 2", "art" => "Volontariat", "fachrichtung" => "fr3");
        $this->max_id++;
        $job3 = array("id" => 2, "bez" => "Test Job 3", "art" => "Festanstellung", "fachrichtung" => "fr4");
        $this->max_id++;
        $job4 = array("id" => 3, "bez" => "Test Job 4", "art" => "Praktikum", "fachrichtung" => "fr6");
        $this->max_id++;
        $job5 = array("id" => 4, "bez" => "Test Job 5", "art" => "Werkstudent", "fachrichtung" => "fr1");
        $this->max_id++;
        
        $this->jobs = array($job1, $job2, $job3, $job4, $job5);
    }

    public function saveJob($job){
        //bearbeiten eines Eintrages
        if(isset($job["id"])){
            
        }
        //neuer Eintrag
        else{
            
            $temp_id = array("id" => "$this->max_id");            
            
            $job = array_merge($job, $temp_id);
            $temp_jobs = array($this->max_id => $job);
            
            
            $this->jobs = array_merge($this->jobs, $temp_jobs);
            
            
            $this->max_id++;
            return $temp_jobs;
        }

    }
    
    public function loadJobs($suchkrit){
        $l_jobs = $this->jobs;
        
        if(empty($suchkrit)){
            return $l_jobs;
        }
        else{        
            foreach($suchkrit as $s_index => $s_value){
                foreach($this->jobs as $job){
                    foreach($job as $j_index => $j_value){
                        if($s_index == $j_index && $s_value != $j_value && in_array($job, $l_jobs, true) === true){
                            unset($l_jobs[array_search($job, $l_jobs)]);
                        }
                    }
                }
            }
                        
        } 
        return $l_jobs;    
    }
           
    public function deleteJob($job_id){         
        if(isset($this->jobs[$job_id])){
            unset($this->jobs[$job_id]);
        }
        
        return $this->jobs;   
    }
}
*/

//Unerlaubter oder fehlerhafter Aufruf?


?>

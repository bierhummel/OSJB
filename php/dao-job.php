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
            
            $id= "select mail from user where id = :id";
            $stmt = $db->prepare($id);
            $stmt->bindParam(':id', $user_email);  
            asdfasdf();
                exit;
            if($job[teilzeit] == 'Teilzeit'){
            
            }
            
            
            
            
        } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }      
    }
        
        

        
        
    
    
    //erhält array mit inputwerten von jobangebot-anlegen.php und gibt true/false zurück
    public function updateJob($job){
        
    }
    
    //erhält entweder array mit inputwerten von index (oder später von filterbox), die e-mail eines nutzers oder eine jobid und gibt zwei-dimensionales array mit den gefundenen jobangeboten als array zurück 
    public function loadJobs($suchkrit){
        
    }
    
    //erhält job_id und gibt true/false zurück
    public function deleteJob($job_id){
        
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

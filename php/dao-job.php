<?php

//Orientiert an Vorlage von http://best-practice-software-engineering.ifs.tuwien.ac.at/patterns/dao.html

interface JobDAO {
    public function saveJob($job);
    public function loadJobs($suchkrit);
    public function deleteJob($job_id);
}

/* Klasse für Zugriff auf Jobs in DB
class DBJobDAO implements JobDAO {

    public DBJobDAO() {

}

    public function saveJob(Job j);
    public function loadJobs($job_ids);
    public function deleteJob (Job j);
}
*/

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


//Unerlaubter oder fehlerhafter Aufruf -> Weiterleitung zum Index
header( 'location: ../index.php' );
exit;


?>

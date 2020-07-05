<?php

//Orientiert an Vorlage von http://best-practice-software-engineering.ifs.tuwien.ac.at/patterns/dao.html

interface JobDAO {
    public function createJob($job, $user_email);
    public function updateJob($job, $job_id);
    public function loadJobs($suchkrit);
    public function deleteJob($job_id);
}
/************************************************
/* Klasse für Zugriff auf Jobs in DB            *
*  Es muss viel ausgelagert werden              *
*  Muss, wenn DB erneuert wird angepasst werden *
************************************************/

class SQLiteJobDAO implements JobDAO {

    //erhält array mit inputwerten von jobangebot-anlegen.php und gibt den neuen job zurück
    public function createJob($job, $user_email){
        //Pfad zur DB
        $database = "../database/database.db";
        // Verbindung wird durch das Erstellen von Instanzen der PDO-Basisklasse erzeugt: 
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $user = null; //Array mit allen wichtigen Informationen des Users (z.b. keine id kein PW)

        try{
            // Default: Anzeige ist aktiv.
            $status = 1;
            //Titel, Strasse, Hausnummer, PLZ und Stadt werden aus den übergebenden Array rausgeholt
            $titel = $job['titel'];
            $strasse = $job['job_strasse'];
            $hausnr = $job['job_hausnr'];
            $plz = $job['job_plz'];
            $stadt = $job['job_stadt'];
            //ID aus der DB holen
            $id = "select id from user where mail = :mail";
            // Statement preparen
            $stmt = $db->prepare($id);
            // Parameter binden
            $stmt->bindParam(':mail', $user_email);  
            // Query ausführen
            $stmt->execute();
            // Da id auo-incement ist: Hole die einzige Zeile die verfügbar ist (id des users)
            $id = $stmt->fetchColumn();
            //Beschäftigungsart und Fachrichtung aus den Array holen
            $beschaeftigungsart = $job['art'];
            $fachrichtung = $job['fachrichtung'];
            //Intensität aus den Array holen (jeweils Teilzeit, Vollzeit oder 20h)
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
            //Jobbezeichnung, Beginn und Link aus den Array holen
            $jobbezeichnung = $job['bez'];
            $beginn = $job['jdate'];
            $link = $job['blink'];
            //Wenn kein Link vorhanden: Setze leeren String auf NULL für die DB
            if($link == ''){
                $link = NULL;
            }
            
            //Qualifikation ermitteln. Diese sind als Boolean (integer 0 oder 1) in der DB realisiert 
            $bachelor = 0;
            $im_bachelor = 0;
            $master = 0;
            $im_master = 0;
            $ausbildung = 0;
            if($job['abachelor'] == 'abachelor'){
                $bachelor = 1;
            }
            if($job['ibachelor'] == 'ibachelor'){
                $im_bachelor = 1;
            }
            if($job['amaster'] == 'amaster'){
                $master = 1;
            }
            if($job['imaster'] == 'imaster'){
                $im_master = 1;
            }
            if($job['ausbildung'] == 'ausbildung'){
                $ausbildung = 1;
            }
            
            //Individuelle Beschreibung aus den Array holen. Wenn keine Beschreibung vorhanden setze Beschreibung auf NULL für die DB.
            $beschreibung = $job['message'];
            if ($beschreibung == ''){
                $beschreibung = NULL;
            }

            // Erstellung der Query für das Eintragen des Jobangebots
            $newJob = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn, erstellt_am) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn, datetime('now'))";
            // Statement preparen
            $stmt = $db->prepare($newJob);
            //Binde die Parameter an die Variablen
            $stmt->bindParam(':uid', $id);  
            $stmt->bindParam(':status', $status);  
            $stmt->bindParam(':titel', $titel); 
            $stmt->bindParam(':strasse', $strasse);       
            $stmt->bindParam(':hausnr', $hausnr);   
            $stmt->bindParam(':plz', $plz);   
            $stmt->bindParam(':stadt', $stadt);   
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
            // Statement ausführen
            $stmt->execute();
            // ID des neuerstellten Jobs aus die DB holen:
            $stmt = $db->query("select id from jobangebot order by id desc limit 1");
            // zurückgegeben String (ein Wert ->FetchColumn) in einen int umwandeln:
            $jid = intval($stmt->fetchColumn());
            //Erzeugung des Rückgabearrays:
            $new_job = array("id" => $jid, "status" => $status, "titel" => $titel, "strasse" => $strasse, "hausnr" => $hausnr, "plz" => $plz, "stadt" => $stadt, "beschreibung" => $beschreibung, "art" => $beschaeftigungsart, "ibachelor" => $im_bachelor, "bachelor" => $bachelor, "imaster" => $im_master, "master" => $master, "ausbildung" => $ausbildung, "fachrichtung" => $fachrichtung, "link" => $link, "beginn" => $beginn, "intensitaet" => $intensitaet);
            //Array returnen:
            return $new_job;
        } 
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }      
    }     
    
    //erhält array mit inputwerten von jobangebot-anlegen.php und gibt id des jobs zurück
    public function updateJob($job, $job_id){
        //Pfad zur DB
        $database = "../database/database.db";
        // Verbindung wird durch das Erstellen von Instanzen der PDO-Basisklasse erzeugt: 
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $user = null; //Array mit allen wichtigen Informationen des Users (z.b. keine id kein PW)

        try{ 
            // Default: Anzeige ist aktiv TODO: Das soll vom User noch verändert werden können?
            $status = 1;
            //TODO: Titel, Strasse, Hausnummer, PLZ und Stadt werden noch nicht abgefragt
            $titel = $job['titel'];
            $strasse = $job['job_strasse'];
            $hausnr = $job['job_hausnr'];
            $plz = $job['job_plz'];
            $stadt = $job['job_stadt'];
            
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
            
            //Qualifikation
            $bachelor = 0;
            $im_bachelor = 0;
            $master = 0;
            $im_master = 0;
            $ausbildung = 0;
            if($job['abachelor'] == 'abachelor'){
                $bachelor = 1;
            }
            if($job['ibachelor'] == 'ibachelor'){
                $im_bachelor = 1;
            }
            if($job['amaster'] == 'amaster'){
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
            $updatedJob = "update jobangebot set status = :status, titel = :titel, strasse = :strasse, hausnr = :hausnr, plz = :plz, stadt = :stadt, beschreibung = :beschreibung, art = :art, zeitintensitaet = :zeitintensitaet, im_bachelor = :im_bachelor, bachelor = :bachelor, im_master = :im_master, master = :master, ausbildung = :ausbildung, fachrichtung = :fachrichtung, link = :link, beschaeftigungsbeginn = :beschaeftigungsbeginn where id = :id";
            
            $stmt = $db->prepare($updatedJob);
            
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
            $stmt->bindParam(':id', $job_id);
            $stmt->execute();
            
            return $job_id;
            
        } catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }      
        return null;
    }     
    
    
    //erhält entweder array mit inputwerten von index (oder später von filterbox), die e-mail eines nutzers oder eine jobid und gibt zwei-dimensionales array mit den gefundenen jobangeboten als array zurück 
    public function loadJobs($suchkrit){
        //Pfad zur DB
        $database = "database/database.db";
        // Verbindung wird durch das Erstellen von Instanzen der PDO-Basisklasse erzeugt: 
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        try{       
        // Fetch-Mode ändern, da sonst doppelte Einträge ins Array eingetragen werden
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        // PLZ und Fachrichtung aus den Suchkriterien-Array holen
        $plz = $suchkrit['plz'];    
        $fachrichtung = $suchkrit['fachrichtung'];
        // Wenn keine Fachrichtung angegeben wurde:    
            if ($fachrichtung == "alle"){
                // Hole alle Jobangebote, wo die PLZ gleich ist mit der eingegebenen PLZ
                $stmt = $db->prepare("select * from jobangebot where plz = ?");
                // Query ausführen und den Parameter binden
                $stmt->execute(array($plz));
                // Das Array wird gespeichert...
                $jobs = $stmt->fetchAll();  
                // und returned
                return $jobs;   
            }
            else {
                // Hole alle Jobangebote, wo die Fachrichtung und PLZ der eingegebenen Fachrichtung / PLZ entspricht und preparen
                $stmt = $db->prepare("select * from jobangebot where plz = ? and fachrichtung = ?"); 
                // Query ausführen und die Parameter binden
                $stmt->execute(array($plz, $fachrichtung));
                // Das Array wird gespeichert...
                $jobs = $stmt->fetchAll();  
                // und returned
                return $jobs;   
            }
        } catch(PDOException $e) {
          // Print PDOException message           
          echo $e->getMessage();
                }    
        } 
    
    
    public function loadJobsOfUser($user_mail){
        //Pfad zur DB
        $database = "database/database.db";
        // Verbindung wird durch das Erstellen von Instanzen der PDO-Basisklasse erzeugt: 
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        try{            
            // Hole die ID des Users mit der eingegebenen Mail
            $id = "select id from user where mail = :mail";
            // Statement vorbereten
            $stmt = $db->prepare($id);
            // Parameter an die user-mail-Variable binden
            $stmt->bindParam(':mail', $user_mail); 
            // Statement ausführen
            $stmt->execute();
             // zurückgegeber Wert aus der Spalte holen
            $id = $stmt->fetchColumn();
            // Fetch-Mode ändern, da sonst doppelte Einträge ins Array eingetragen werden
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            // Alle Jobangebot des Users aus der DB holen
            $stmt = $db->prepare("select * from jobangebot where user_id = ?");
             // Query ausführen und den Parameter binden
            $stmt->execute(array($id));
             // Das Array wird gespeichert...
            $jobs = $stmt->fetchAll(); 
            // und returned
            return $jobs;
        } 
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }    
    } 
        
    
    
    public function loadJob($job_id){
        //Pfad zur DB
        $database = "database/database.db";
        // Verbindung wird durch das Erstellen von Instanzen der PDO-Basisklasse erzeugt: 
        $db = new PDO('sqlite:' . $database);
        // Leeres Array erzeugen, das später returned werden sol
        $job = null;
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        try{         
            // Fetch-Mode ändern, da sonst doppelte Einträge ins Array eingetragen werden
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            // Alle Jobangebot des Users aus der DB holen
            $stmt = $db->prepare("select * from jobangebot where id = ?");
             // Query ausführen und den Parameter binden
            $stmt->execute(array($job_id));
             // Das Array wird gespeichert...
            $job = $stmt->fetch();     
            // und returned
            return $job;
        }
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }    
    } 
        
        
    
    
    //erhält job_id und gibt true/false zurück
    public function deleteJob($job_id){
        $database = "database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

        try{
            // Job der Job-id soll aus der DB entfernt werden:
            $delJob = "delete from jobangebot where id = :id";
            // Statement preparen und Parameter an Variable job_id binden
            $stmt = $db->prepare($delJob);
            $stmt->bindParam(':id', $job_id);
            // Query ausführen
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }   
        return false;
    }     
}


//DummyJobDAO funktioniert wahrscheinlich nicht mehr vollständig
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

//Unerlaubter oder fehlerhafter Aufruf abfangen?

?>

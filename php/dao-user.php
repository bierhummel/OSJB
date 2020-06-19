<?php


/*
class Benutzer {
    private $email;
    private $name;
    private $password;

    public function getName() {
        return $this->name;
    }

    public function setName( $name ) {
        $this->_name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail( $email ) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword( $password ) {
        $this->password = $password;
    }

}
*/
//TODO: Die Prepared Statements auslagern und einen Connector erstellen, damit es übersichtlicher wird

interface UserDAO {
    public function loginUser( $email, $password );
    
    public function updateUser( $user );

    public function registerUser( $user );
    
    public function deleteUser(  $user_id, $password );
    
    //public function activateUser(); Übergangsweise neuer Benutzer direkt aktiv
}

class SQLiteUserDAO implements UserDAO {
    private $database = "../database/database.db";
    private $db;
    
    public function loginUser( $input_mail, $input_pw ){

        // Skript durchlaufen lassen, um zu überprüfen ob DB vorhanden ist.
        include_once('check-connection.php'); 
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $user_id = null; //Array mit allen wichtigen Informationen des Users (z.b. kein PW und Logo)

        /*test*/
        //$user_id = array("id" => 0, "vorname" => "abc", "nachname" => "jas");
        try{      
            $hashed_password = "select password from user where mail = :mail";
            var_dump($input_mail);
            $stmt = $db->prepare($hashed_password);
            $stmt->bindParam(':mail', $input_mail);  
            $stmt->execute();
     
            $pw_in_db = $stmt->fetchColumn();
            if (password_verify($input_pw, $pw_in_db)) {
                //id
                $id = "select id from user where mail = :mail";
                $stmt = $db->prepare($id);
                $stmt->bindParam(':mail', $input_mail);  
                $stmt->execute();
                $id_in_db = $stmt->fetchColumn();
                $id_in_db = intval($id_in_db);
                //vorname
                $vname = "select vname from user where mail = :mail";
                $stmt1 = $db->prepare($vname);
                $stmt1->bindParam(':mail', $input_mail);  
                $stmt1->execute();
                $vname = $stmt1->fetchColumn();               
                //nachname
                $nname = "select nname from user where mail = :mail";
                $stmt2 = $db->prepare($nname);
                $stmt2->bindParam(':mail', $input_mail);  
                $stmt2->execute();
                $nname = $stmt2->fetchColumn();   
                //array bilden
                $user_id = array("id" => $id_in_db, "vorname" => $vname, "nachname" => $nname);
                return $user_id;
            } else {
                return null;
                }
            } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                }
        
    }
    

    
    public function updateUser( $user ){
        $user_id = null; //Array mit aktualisierten wichtigen Informationen des Users (z.b. kein PW und Logo) 
        // Skript durchlaufen lassen, um zu überprüfen ob DB vorhanden ist.
        include_once('check-connection.php');  
        // Erzeugen eines PDO's für die Transaktion    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{      

            $update = "update user set strasse = :strasse, hausnr = :hausnr, plz = :plz, stadt = :stadt where mail = :mail";
            
            //Werte aus dem Array holen    
            $strasse = $user[strasse];
            $hausnr = $user[hausnr];
            $plz = $user[plz];
            $stadt = $user[stadt];
            $user = [email1];
            $mail = "der-tuerklinkenputzer@yahoo.de"; //$user[email]""; Nutzer existiert in der DB! 
            $stmt = $db->prepare($update);
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':strasse', $strasse);
            $stmt->bindParam(':hausnr', $hausnr);
            $stmt->bindParam(':plz', $plz);       
            $stmt->bindParam(':stadt', $stadt);   
            $stmt->bindParam(':mail', $mail);   
                       
            // Und führe die Transaktion letzlich aus.
            $stmt->execute();
            $db = NULL;    
            $user_id = array("strasse" => $strasse, "hausnr" => $hausnr, "plz" => $plz, "stadt"=> $stadt);
        } catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }
        
        return $user_id;
        
    }

    public function registerUser($user){
        // Skript durchlaufen lassen, um zu überprüfen ob DB vorhanden ist.
        include_once('check-connection.php');  
        // Erzeugen eines PDO's für die Transaktion    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $succes = false;
        //Werte aus dem Array holen
        $uname = $user[firma];
        $vname = $user[vorname];
        $nname = $user[nachname];
        $password = $user[passwort1];
        $mail = $user[email1];
        //Verified und mail_verified sind standardmäßig false (bzw. 0)
        $verified = 0;
        $mail_verified = 0;
        //Passwort mit bcrypt hashen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);        
        
        if (!($this->userAlreadyExists(($mail)))){
            // Wenn die Mail des Uers noch nicht in der DB ist:
            try{
                // Bereite die Transaktion vor,
                $register = "insert into user (uname, vname, nname, password, mail, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :verified, :mail_verified)";
                $stmt = $db->prepare($register);
                // Binde die Parameter an die Variablen,
                $stmt->bindParam(':uname', $uname);  
                $stmt->bindParam(':vname', $vname);
                $stmt->bindParam(':nname', $nname);    
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':verified', $verified);
                $stmt->bindParam(':mail_verified', $mail_verified);
                // Und führe die Transaktion letzlich aus.
                $stmt->execute();
                // Ist dies passiert, liefere true zurück...
                $succes = true;
                // Und schließe die Verbindung zur DB.
                $db = null;
        
                } catch(PDOException $e) {
                    // Print PDOException message
                    echo $e->getMessage();
                    $success = false;
                }

        } else {
            $success = false;
        }
            return $succes;  
          
    }
    
    public function deleteUser(  $user_id, $password ){}
    
    private function userAlreadyExists($mail){
    try{
            // Erzeugen eines PDO's für die Transaktion   
            $database = "../database/database.db";
            $db = new PDO('sqlite:' . $database);
            // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Bereite die Transaktion vor,
            $exists = "select count(*) from user where mail = :mail";
            $stmt = $db->prepare($exists);
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':mail', $mail);
            // Und führe die Transaktion letzlich aus.
            $stmt->execute();
            // Wir schnappen uns die einzige Spalte count(*) und zählen nach, ob die Mail vorhanden ist.    
            $count = $stmt->fetchColumn();
            // Es wird ein String zurückgegeben. Dieser wird zum Integer gecastet    
            $count = intval($count);
            // Wenn die Mail noch nicht vorhanden ist:
            if ($count == 0){
                // Schließe die Verbindung zur DB.
                $db = null;
                // Und gebe, false zurück: Der User existiert noch nicht in unsere Datenbank.
                return false;
        }
            else {
                // Schließe die Verbindung zur DB.
                $db = null;
                 // Und gebe, true zurück: Der User existiert bereits in unsere Datenbank.
                return true;
        }
        
        } catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }
    }
    
}


/*
class DummyUserDAO implements UserDAO {

    public function load( $email, $password ) {
        $u = new Benutzer();
        $email = $u->getEmail();
        $password = $u->getPassword();
    }

    public function save( $name, $email, $password ) {

        $x = new Benutzer();

        $x->setEmail( $email );
        $x->setName( $name );
        $x->setEmail( $password );

    }

    public function update( $name, $email, $password ) {
        $y = new Benutzer();
        $y-> getEmail( $email );
        $y-> getName( $name );
        $y-> getPassword( $password );
    }
}
*/


//Unerlaubter oder fehlerhafter Aufruf?


?>
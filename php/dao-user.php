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
    
    public function loginUser( $email, $password ){
        
        $user_id = null; //Array mit allen wichtigen Informationen des Users (z.b. kein PW und Logo)
        
        /*test*/
        $user_id = array("id" => 0, "vorname" => "abc", "nachname" => "jas");
        
        
        return $user_id;
    }
    

    
    public function updateUser( $User ){
        $user_id = null; //Array mit aktualisierten wichtigen Informationen des Users (z.b. kein PW und Logo)
        
        /*test*/
        $user_id = array("id" => 0, "vorname" => "test", "nachname" => "jas");
        
        
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
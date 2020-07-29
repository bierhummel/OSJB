<?php


interface UserDAO {
    public function loginUser( $email, $password );
    
    public function updateUser( $user, $email );

    public function registerUser( $user );
    
    public function verifyUser(  $token );
    
    public function deleteUser(  $user_id, $password );
}

/****************************************************************************
/* Klasse für Zugriff auf User in DB                                        *
*  TODO: Die Prepared Statements auslagern und einen Connector erstellen,   *
*  damit es übersichtlicher wird                                            *
****************************************************************************/

class SQLiteUserDAO implements UserDAO {
    //ruhig auch benutzen anstatt immer wieder neu angeben?
    private $database = "../database/database.db";
    private $db;
    
    
    public function loginUser( $input_mail, $input_pw ){
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        $user = null; //Array mit allen Informationen des Users

        try{      
            $hashed_password = "select password from user where mail = :mail";
            $stmt = $db->prepare($hashed_password);
            $stmt->bindParam(':mail', $input_mail);  
            $stmt->execute();
     
            $pw_in_db = $stmt->fetchColumn();
            
            if (password_verify($input_pw, $pw_in_db)) {
                $stmt = $db->prepare("select * from user WHERE mail = ?");
                $stmt->execute(array($input_mail));
                $user = $stmt->fetch();  

                return $user;              
            } 
            else {
                return null;
            }
        } 
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }        
    }
    

    //Offen: Passwörter ändern. Sinnvoll das E-Mail einfach so geändert werden darf?
    public function updateUser( $updated_user, $input_mail ){
        $user = null; //Array mit allen Informationen des Users
        
        // Erzeugen eines PDO's für die Transaktion    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 

        try{
            //Statement entwerfen
            $update = "update user set uname = :new_uname, vname = :new_vname, nname = :new_nname, strasse = :new_strasse, hausnr = :new_hausnr, plz = :new_plz, stadt = :new_stadt where mail = :mail";
            
            //mail = :new_mail, rausgenommen
            
            //Statement preparen
            $stmt = $db->prepare($update);
            
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':new_uname', $updated_user["new_firma"]);
            $stmt->bindParam(':new_vname', $updated_user["new_vorname"]);
            $stmt->bindParam(':new_nname', $updated_user["new_nachname"]);
            //$stmt->bindParam(':new_mail', $updated_user["new_email"]);
            $stmt->bindParam(':new_strasse', $updated_user["new_strasse"]);
            $stmt->bindParam(':new_hausnr', $updated_user["new_hausnr"]);
            $stmt->bindParam(':new_plz', $updated_user["new_plz"]);       
            $stmt->bindParam(':new_stadt', $updated_user["new_stadt"]); 
            $stmt->bindParam(':mail', $input_mail);   
            
            // Und führe die Transaktion letzlich aus.
            $stmt->execute();
            
            //rückgabewerte auslesen (mit ggf. geändertet E-Mail)
            //unternehmensname
            $stmt = $db->prepare("select * from user WHERE mail = ?");
            $stmt->execute(array($input_mail));   
            $user = $stmt->fetch();    

            return $user;   
        } 
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }
        
    }

    public function registerUser($user){
        // Skript durchlaufen lassen, um zu überprüfen ob DB vorhanden ist.
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
        $hash = md5(rand());
        //Verified und mail_verified sind standardmäßig false (bzw. 0)
        $verified = 0;
        $mail_verified = 0;
        //Passwort mit bcrypt hashen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);        
        
        //Ist so nicht optimal: Sollte eine gemeinsame Transaktion sein
        if (!($this->userAlreadyExists(($mail)))){
            // Wenn die Mail des Uers noch nicht in der DB ist:
            try{
                // Bereite die Transaktion vor,
                $register = "insert into user (uname, vname, nname, password, mail, hash, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :hash, :verified, :mail_verified)";
                $stmt = $db->prepare($register);
                // Binde die Parameter an die Variablen,
                $stmt->bindParam(':uname', $uname);  
                $stmt->bindParam(':vname', $vname);
                $stmt->bindParam(':nname', $nname);    
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':hash', $hash);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':verified', $verified);
                $stmt->bindParam(':mail_verified', $mail_verified);
                // Und führe die Transaktion letzlich aus.
                $stmt->execute();
                // Ist dies passiert, liefere true zurück...
                $succes = true;
                // Und schließe die Verbindung zur DB.
                $db = null;
            } 
            catch(PDOException $e) {
                // Print PDOException message
                echo $e->getMessage();
                $hash = '';
            }

        } 
        else {
            $hash = 'existiert';
        }
        
        return $hash;  
    }
    
    public function verifyUser( $token ){
        try{
            $database = "../database/database.db";
            $db = new PDO('sqlite:' . $database);
            // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $verify = "update user set mail_verified = 1 WHERE hash= :hash";
            $stmt = $db->prepare($verify);
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':hash', $token);
            // Und führe die Transaktion letzlich aus.
            $stmt->execute();
            
            return true;
        }
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }
        
        return false;
    }
    
    
    public function deleteUser(  $user_id, $password ){
        
    }
    
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
        } 
        catch(PDOException $e) {
            // Print PDOException message
            echo $e->getMessage();
        }
    }
}

?>
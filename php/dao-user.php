<?php

interface UserDAO {
    public function loginUser( $email, $password );
    public function updateUser( $user, $email );
    public function registerUser( $user );
    public function verifyUser(  $token );
    //public function deleteUser(  $user_id, $password ); Gestrichen nach Inhaltsreduzierung, da nur noch zu 2.
}

/****************************************************************************
/* Klasse für Zugriff auf User Tabelle in DB                                *
****************************************************************************/

class SQLiteUserDAO implements UserDAO {
    
    //Erhält eingegebene Mail und PW von login.php und gibt bei Erfolg den Datensatz des Users oder null zurück
    public function loginUser( $input_mail, $input_pw ){
        //Variable für Rückgabe von Datensatz des Users initialisieren
        $user = null;
        
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Fetch-Mode ändern, da sonst doppelte Einträge ins Array eingetragen werden
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        try{ 
            //Transaktion beginnen
            $db->beginTransaction();
            
            //Lese das abgespeicherte PW des Users aus DB und speichere in Variable
            $hashed_password = "select password from user where mail = :mail";
            $stmt = $db->prepare($hashed_password);
            $stmt->bindParam(':mail', $input_mail);  
            $stmt->execute();
            $pw_in_db = $stmt->fetchColumn();

            //Vergleiche PW aus DB mit dem eingegebenen PW
            if( password_verify($input_pw, $pw_in_db) ) {
                
                //Bei Übereinstimmung: Lese Datensatz des User aus DB und speichere in Variable
                $stmt = $db->prepare("select * from user WHERE mail = ?");
                $stmt->execute(array($input_mail));
                $user = $stmt->fetch();  
            } 
            //Transaktion mit commit beenden
            $db->commit();
            
            //Datensatz des Users oder null zurückgeben
            return $user;
        } 
        catch(PDOException $e) {
            // Print PDOException message
            //echo $e->getMessage();
            
            //Transaktion mit rollback beenden
            $db->rollBack();
            
            return $user;
        }        
    } //Ende loginUser
    

    //Erhält eingegebene Userdaten von profil.php für Update und gibt bei Erfolg den Datensatz des Users oder null zurück
    public function updateUser( $updated_user, $input_mail ){
        $user = null; ////Variable für Rückgabe von Datensatz des Users initialisieren
        
        // Erzeugen eines PDO's für die Transaktion    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Fetch-Mode ändern, da sonst doppelte Einträge ins Array eingetragen werden
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        try{
            //Transaktion beginnen
            $db->beginTransaction();
            
            //Statement entwerfen
            $update = "update user set uname = :new_uname, vname = :new_vname, nname = :new_nname, strasse = :new_strasse, hausnr = :new_hausnr, plz = :new_plz, stadt = :new_stadt where mail = :mail";
            
            //mail = :new_mail, rausgenommen nach Inhaltsreduzierung
            
            //Statement preparen
            $stmt = $db->prepare($update);
            
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':new_uname', $updated_user["new_firma"]);
            $stmt->bindParam(':new_vname', $updated_user["new_vorname"]);
            $stmt->bindParam(':new_nname', $updated_user["new_nachname"]);
            //$stmt->bindParam(':new_mail', $updated_user["new_email"]); rausgenommen nach Inhaltsreduzierung
            $stmt->bindParam(':new_strasse', $updated_user["new_strasse"]);
            $stmt->bindParam(':new_hausnr', $updated_user["new_hausnr"]);
            $stmt->bindParam(':new_plz', $updated_user["new_plz"]);       
            $stmt->bindParam(':new_stadt', $updated_user["new_stadt"]); 
            $stmt->bindParam(':mail', $input_mail);   
            
            // Und führe die Aktion letzlich aus.
            $stmt->execute();
            
            //rückgabewerte auslesen
            $stmt = $db->prepare("select * from user WHERE mail = ?");
            $stmt->execute(array($input_mail));   
            $user = $stmt->fetch();    

            //Transaktion mit commit beenden
            $db->commit();
            
            //Datensatz des Users zurückgeben
            return $user;   
        } 
        catch(PDOException $e) {
            // Print PDOException message
            //echo $e->getMessage();
            
            //Transaktion mit rollback beenden
            $db->rollBack();
            
            return $user;
        }
    } //Ende updateUser
    

    //Erhält eingegebene Registrierungsdaten von login.php und gibt bei Erfolg den Bestätigungs-Hash zurück, mit dem die Registrierung abgeschlossen werden kann.
    public function registerUser($user){
        // Erzeugen eines PDO's für die Transaktion    
        $database = "../database/database.db";
        $db = new PDO('sqlite:' . $database);
        // Errormode wird eingeschaltet, damit Fehler leichter nachvollziehbar sind.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //Eingabewerte aus dem Übergabearray holen
        $uname = $user["firma"];
        $vname = $user["vorname"];
        $nname = $user["nachname"];
        $password = $user["passwort1"];
        $mail = $user["email1"];
        
        //Passwort mit bcrypt hashen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        //Bestätigungs-Hash, mit dem die Registrierung abgeschlossen werden kann erstellen
        $hash = uniqid();
        
        //Verified ist standardmäßig 1 bzw. true (manueles finales freischalten eines Users nach Inhaltsreudzierungs verworfen) und mail_verified ist standardmäßig 0 (bzw. false)
        $verified = 1;
        $mail_verified = 0;
        
        try{
            //Transaktion beginnen
            $db->beginTransaction();
            
            //Prüfe, ob die Mail schon in der DB vorliegt und falls ja, ob sie bereits verifiziert wurde oder nicht.
            $exists = $this->userAlreadyExists($mail, $db);
            
            // Wenn die Mail des Uers noch nicht in der DB ist:
            if( !( $exists ) ){
                // Bereite die Insert vor,
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
                // Und führe die Aktion letzlich aus.
                $stmt->execute();
            } 
            //Wenn die Mail des Uers schon in der DB und verifiziert ist:
            elseif( $exists == "verified") {
                //Setze festen Hash
                $hash = 'existiert';
            }
            //Wenn die Mail des Uers schon in der DB, aber noch nicht verifiziert ist:
            else {
                
                // Bereite die Update vor, um vorhandenen Datensatz mit den aktuellen Daten zu aktualisieren (Hash, mail, id, etc. bleibt gleich)
                $registerUpdate = "update user set uname = :new_uname, vname = :new_vname, nname = :new_nname, password = :password where mail = :mail";
                $stmt = $db->prepare($registerUpdate);

                // Binde die Parameter an die Variablen,
                $stmt->bindParam(':new_uname', $uname);  
                $stmt->bindParam(':new_vname', $vname);
                $stmt->bindParam(':new_nname', $nname);    
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':mail', $mail);
                // Und führe die Aktion letzlich aus.
                $stmt->execute();
                
                //Übernehme existierenden Hash
                $hash = $exists;
            }
            
            //Transaktion mit commit beenden
            $db->commit();
        }
        catch(PDOException $e) {
            // Print PDOException message
            //echo $e->getMessage();
            $hash = null;
            
            //Transaktion mit rollback beenden
            $db->rollBack();
        }
        //Neuen Hash, alten noch nicht verifizierten Hash, "exisitert" oder null zurückgeben
        return $hash;
        
    } //Ende registerUser
    
    
    //Erhält token aus Fake-Mail und verifiziert den User.
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
            // Und führe die Aktion letzlich aus.
            $stmt->execute();
            
            return true;
        }
        catch(PDOException $e) {
            // Print PDOException message
            //echo $e->getMessage();
            return false;
        }
    } //Ende verifyUser
    
    
    /*Inhaltsreduzierung, da nur noch zu 2.
    public function deleteUser(  $user_id, $password ){  
    }
    */
    
    
    //Bekommt eine Mailadresse und eine bestehendes PDO und prüft, ob die Mail schon in der DB vorliegt und falls ja, ob sie bereits verifiziert wurde oder nicht. In diesem fall gib den noch nicht bestätigten Hash zurück.
    private function userAlreadyExists($mail, $db){
        try{
            // Bereite die Statement vor,
            $exists = "select * from user where mail = :mail";
            $stmt = $db->prepare($exists);
            // Binde die Parameter an die Variablen,
            $stmt->bindParam(':mail', $mail);
            // Und führe die Aktion letzlich aus.
            $stmt->execute();
            
            // Wir schnappen uns das Ergebnis und überprüfen es
            $result = $stmt->fetch();
            
            // Wenn die Mail noch nicht vorhanden ist:
            if ($result == false){
                // Gebe false zurück: Der User existiert noch nicht in unsere Datenbank.
                return false;
            }
            elseif( $result["mail_verified"] == 0 ) {
                 // Gebe den Hash zurück: Der User existiert bereits in unsere Datenbank, wurde aber noch nicht verifiziert.
                return $result["hash"];
            }
            else {
                 // Gebe true zurück: Der User existiert bereits in unsere Datenbank und wurde bereits verifiziert.
                return "verified";
            }
        } 
        catch(PDOException $e) {
            // Print PDOException message
            //echo $e->getMessage();
            return null;
        }
    } //Ende userAlreadyExists
    
} //Ende SQLiteUserDAO

?>
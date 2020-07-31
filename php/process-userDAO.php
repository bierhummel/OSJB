<?php
//Datei, die alle wichtigen Prozesse verarbeitet, für die auf das User-DAO zugeriffen wird

//Überprüfung der übergebenen Eingabedaten zum Schutz vor XSS, egal ob GET oder POST
    include('helper-checkInputs.php'); 
    $request_checked = check_inputs($_REQUEST);


//Initialisierungen und Includes
    //Wenn noch keine Session gestartet, Session starten (Wichtig da teilweise von Formularen direkt aufgerufen, teilweise als include in View enthalten -> nicht mehr aktuell?)
    if(session_status() != 2){
        //session starten
        ini_set( 'session.use_cookies', 1 );
        ini_set( 'session.use_only_cookies', 0 );
        ini_set( 'session.use_trans_sid', 1 );
        session_start();  
    } 

    //Einbindung des DAO
    include('dao-user.php'); 
    $UserDAO = new SQLiteUserDAO();

//Aufgaben, für die diese Datei direkt aufgerufen wird: 
    //Login
    if ( isset($request_checked['login']) && isset($request_checked['email']) && isset($request_checked['passwort']) ) {
        
        //Aufruf von loginUser() des UserDAO
        $user = $UserDAO->loginUser($request_checked['email'], $request_checked['passwort']);
        
        //Login erfolgreich und auszugebende Userdaten als Array erhalten
        if( $user != NULL && $user["mail_verified"] == 1){            
            $_SESSION["login"] = "success";
            $_SESSION["eingeloggt"] = "true";
            
            //Alle unkritischen Infos des Users in Session zwischenspeichern
            foreach ($user as $index => $value){
                if( $index != "id" && $index != "password" && $index != "verified" && $index != "mail_verified"){
                    $_SESSION[$index] = $value;
                }
            }
            //Zusätzlich ein Token in der Session speichern zum Schutz vor CSRF-Angriffen
            $_SESSION["csrf_token"] = uniqid();
            
            //Profil aufrufen
            header( 'location: ../profil.php' );
            exit;
        }
        //Login nicht erfolgreich
        else{
            $_SESSION["login"] = "fail";
            header( 'location: ../login.php' );
            exit;
        }      
    }


    //Userdaten updaten
    if ( isset( $request_checked['updaten']) && isset($_SESSION["eingeloggt"]) && isset($request_checked["csrf_token"]) && $request_checked['csrf_token'] == $_SESSION["csrf_token"] ) {
        
        //Falls ein File hochgeladen wurde, den File-Upload erledigen
        $uploadedFile = null;
        
        
        if( isset($_FILES['new_logo']) && $_FILES['new_logo']["name"] != "" ) {
            include('helper-fileUpload.php');
            $uploadedFile = fileUpload( $_FILES );
        }
        //Pfad der Hochgeladenen Datei an request anhängen
        $request_checked['uploadedFile'] = $uploadedFile;
        
        
        //Aufruf von updateUser() des UserDAO
        $user = $UserDAO->updateUser($request_checked, $_SESSION["mail"]);
        
        //Update erfolgreich und neue auszugebende Userdaten als Array erhalten
        if( $user != NULL ){            
            $_SESSION["update"] = "success";
            
            //Alle unkritischen infos des Users in Session zwischenspeichern
            foreach ($user as $index => $value){
                if( $index != "id" && $index != "password" ){
                    $_SESSION[$index] = htmlspecialchars($value);
                }
            }
            
            //Danach Profil wieder aufrufen
            header( 'location: ../profil.php' );
            exit;
        } 
        //Update nicht erfolgreich
        else{
            //Fehlermeldung setzen und Profil wieder aufrufen
            $_SESSION["update"] = "fail";
            header( 'location: ../profil.php' );
            exit;
        } 
    }

    //Registrierung
    if ( isset($request_checked['registrieren']) && isset($request_checked['email1']) && isset($request_checked['NB_DS_check']) ) {
        
        //Prüfen der Passworteingabe
        if( isset($request_checked['passwort1']) && isset($request_checked['passwort2']) && strlen($request_checked['passwort1']) >= 8 && $request_checked['passwort1'] == $request_checked["passwort2"] ) {
            
            //Aufruf von registerUser() des UserDAO
            $token = $UserDAO->registerUser($request_checked);
            
            //Prüfen, was für ein Token zurückgegeben wrude:
            //Mail ist bereits verifiziert
            if( $token == 'existiert'){
                
                //Falls bereits ein File existiert, wird dieses gelöscht
                if( file_exists("verification/".$token.".txt") ) {
                    unlink("verification/".$token.".txt");
                }
                
                //pfad in Session speichern für Aufruf von login.php aus
                $_SESSION["tokenpfad"] = "php/verification/".$token.".txt"; 
                //Flag wird gesetzt, dass in login.php der Link angezeigt wird
                $_SESSION["registrierung"] = "verifizierung"; 
                
                //Text der Fake-Mail wird gespeichert
                $text = "Disclaimer: Dieser Text soll eine automatisch generierte E-Mail an die angegebene Adresse simulieren.
                
                Sehr geehrte/r " . $request_checked['email1'] . ", 
                
                Sie sind bereits bei der OSJB registriert. 
                
                Sollten Sie Ihr Passwort vergessen haben, nehmen Sie bitte direkt Kontakt mit uns auf unter kontakt@osjb.de. 
                Falls Sie nicht selbst versucht haben, sich mit dieser Mailadresse zu registrieren, ignorieren Sie diese Mail bitte einfach.
                
                Freundliche Gruesse
                Das OSJB-Team";
                
                //Erstelle Fake-Mail als .txt-Datei
                $data = "verification/".$token.".txt"; 
                $handler = fopen($data , "a+");
                fwrite($handler , $text);
                fclose($handler);
            }
            
            //Falls Mail noch nicht verifiziert
            elseif ($token != null ){
                
                //Falls bereits ein File existiert, wird dieses gelöscht
                if( file_exists("verification/".$token.".txt") ) {
                    unlink("verification/".$token.".txt");
                }
                
                //pfad in Session speichern für Aufruf von login.php aus
                $_SESSION["tokenpfad"] = "php/verification/".$token.".txt"; 
                //Flag wird gesetzt, dass in login.php der Link angezeigt wird
                $_SESSION["registrierung"] = "verifizierung"; 
                
                //Text der Fake-Mail wird gespeichert
                $text = "Disclaimer: Dieser Text soll eine automatisch generierte E-Mail an die angegebene Adresse simulieren.
                
                Sehr geehrte/r " . $request_checked['email1'] . ", 
                
                Herzlich Willkommen bei OSJB.
                
                Klicken Sie bitte auf folgenen Link, um ihr Konto zu verifizieren: http://localhost/".$_SERVER['PHP_SELF']."?token=".$token . ".
                Falls Sie nicht selbst versucht haben, sich mit dieser Mailadresse zu registrieren, ignorieren Sie diese Mail bitte einfach.
                
                Freundliche Gruesse
                Das OSJB-Team";

                //Erstelle Fake-Mail als .txt-Datei
                $data = "verification/".$token.".txt"; 
                $handler = fopen($data , "a+");
                fwrite($handler , $text);
                fclose($handler);
            }
            
            //Falls Fehler im DAO passiert
            else{
                //Flag wird gesetzt, damit login.php eine Fehlermeldung anzeigt 
                $_SESSION["registrierung"] = "db_fail";
            }
        }
        //Passworteingabe fehlerhaft
        else{
            //Flag wird gesetzt, damit login.php eine Fehlermeldung anzeigt 
            $_SESSION["registrierung"] = "pw_fail";
        }
        
        //In jedem Fall Login wieder aufrufen, wo entsprechende Meldungen ausgegeben werden.
        header( 'location: ../login.php' );
        exit;        
    }
    
    //Registrierung abschließen
    //Wenn ein existierender Token aufgerufen wird
    if ( isset($request_checked['token']) && $request_checked['token'] != "" && file_exists('verification/'.$request_checked['token'].'.txt') ) {
        
        //Verifiziere den Nutzer
        $verifiziert = $UserDAO->verifyUser($request_checked['token']);
        
        //Bei Erfolg
        if($verifiziert) {
            ////Flag wird gesetzt, damit login.php eine Erfolgsmeldung anzeigt
            $_SESSION["registrierung"] = "success"; 
            
            //.txt-Datei löschen
            unlink('verification/'.$request_checked['token'].'.txt');
        }
        //Bei Fehlschlag
        else{
            //Flag wird gesetzt, damit login.php eine Fehlermeldung anzeigt 
            $_SESSION["registrierung"] = "db_fail";
        }
        
        //In jedem Fall Login wieder aufrufen, wo entsprechende Meldungen ausgegeben werden.
        header( 'location: ../login.php' );
        exit; 
    }
    //Wenn ein Token gesetzt wurde, der nicht existiert:
    elseif( isset($request_checked['token']) ) {
        //Flag wird gesetzt, damit login.php eine Fehlermeldung anzeigt 
        $_SESSION["registrierung"] = "token_fail";
        
        //login.php wieder aufrufen, wo entsprechende Meldung ausgegeben werden.
        header( 'location: ../login.php' );
        exit;
    }

    
    //User löschen (Im Zuge der Inhaltsreduzierung gestrichen)


//Unerlaubter oder fehlerhafter Aufruf -> Weiterleitung zum Index
    header( 'location: ../index.php' );
    exit;

?>

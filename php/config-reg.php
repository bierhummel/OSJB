<?php

//Datei umbennen zu process-user?


//Überprüfung der Eingabedaten
    include('check-inputs.php'); 
    /*$get_checked = check_get($_GET);
    $post_checked = check_get($_POST);*/
    $request_checked = check_inputs($_REQUEST);


//Geschäftslogik der Verwaltung von Usern
    
    //Wenn noch keine Session gestartet, Session starten (Wichtig da teilweise von Formularen direkt aufgerufen, teilweise als include in View enthalten)
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

    
    //Login
    if ( isset( $request_checked['login'] ) ) {
        
        //Aufruf von loginUser() des UserDAO
        $user = $UserDAO->loginUser($request_checked['email'], $request_checked['passwort']);
        
        //Login erfolgreich und auszugebende Userdaten als Array erhalten
        if( $user != NULL && $user["mail_verified"] == 1){            
            $_SESSION["login"] = "success";
            $_SESSION["eingeloggt"] = "true";
            
            //Alle unkritischen Infos des Users in Session zwischenspeichern
            foreach ($user as $index => $value){
                if( $index != "id" && $index != "password" && $index != "verified" && $index != "mail_verified"){
                    $_SESSION[$index] = htmlspecialchars($value);
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

            header( 'location: ../profil.php' );
            exit;
        } 
        //Update nicht erfolgreich
        else{
            $_SESSION["update"] = "fail";
            header( 'location: ../login.php' );
           exit;
        } 
    }


    //Registrierung
    if ( isset( $request_checked['registrieren'] ) ) {
        
        //Prüfen der Passworteingabe
        if( $request_checked['passwort1'] == $request_checked["passwort2"] ) {
            
            //Aufruf von registerUser() des UserDAO
            $token = $UserDAO->registerUser($request_checked);
            
            $_SESSION["tokenpfad"] = "php/verification/tmp/".$token.".txt"; 

            /* Dibo: Entweder ihr implementiert die Registrierung durch versenden von E-Mails oder um das immer wieder aufkommende Problem mit Mails und Mail-Servern zu umgehen, simuliert ihr es wie folgt: Nach dem Registrieren wird keine echte E-Mail verschickt, sondern es kommt der Hinweis: „Es wurde eine E-Mail an die angegebene Adresse verschickt mit weiteren Infos.“ + Link zu einer (temporären) txt-Datei, wo der E-Mail-Text drin steht. -> umsetzung fehlt noch */        

            if( $token == 'existiert'){
                $_SESSION["registrierung"] = "verifizierung"; 
                $text = "Sie sind bereits registriert. Sollten Sie Ihr Passwort vergessen haben klicken Sie hier (folgt noch). Falls Sie nicht selbst versucht haben sich mit dieser Mailadresse zu registrieren, ignorieren Sie diese Mail bitte einfach.";
                
                $data = "verification/tmp/".$token.".txt"; 
                $handler = fopen($data , "a+");
                fwrite($handler , $text);
                fclose($handler);
                
                
            }
            elseif ($token != '' ){            
                $_SESSION["registrierung"] = "verifizierung"; 
                $text = "Herzlich Willkommen bei OSJB. Klicken Sie bitte auf folgenen Link, um ihr Konto zu verifizieren: http://localhost/".$_SERVER['PHP_SELF']."?token=".$token . ". Falls Sie nicht selbst versucht haben sich mit dieser Mailadresse zu registrieren, ignorieren Sie diese Mail bitte einfach."; 
                
                $data = "verification/tmp/".$token.".txt"; 
                $handler = fopen($data , "a+");
                fwrite($handler , $text);
                fclose($handler);
            }
            
            else{
                $_SESSION["registrierung"] = "db_fail"; //später genauere Unterscheidungen

            }
        }
        else{
            $_SESSION["registrierung"] = "pw_fail";
        }
        
        header( 'location: ../login.php' );
        exit;        
    }
    
    //Registrierung abschließen
    if ( isset($request_checked['token']) && $request_checked['token'] != "" && file_exists('verification/tmp/'.$request_checked['token'].'.txt' ) ) {
        
        $verifiziert = $UserDAO->verifyUser($request_checked['token']);
        
        if($verifiziert) {
             $_SESSION["registrierung"] = "success"; 
            echo "Übergangslösung: Die Mail wurde erfolgreich bestätigt.";
            unlink('verification/tmp/'.$request_checked['token'].'.txt');
        }
        else{
            echo "Fehler.";
        }
        
        echo "<br> <a href=../login.php>Zurück zum Login</a>";
        exit;
    }
    elseif( isset($request_checked['token']) ) {
        echo "Übergangslösung: Kein entsprechender Token vorhanden.";
        echo "<br> <a href=../login.php>Zurück zum Login</a>";
        exit;
    }


    
    //User löschen (fehlt noch)


//Erzeugung von Ausgabedaten?



//Unerlaubter oder fehlerhafter Aufruf -> Weiterleitung zum Index
header( 'location: ../index.php' );
exit;


?>

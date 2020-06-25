<?php

//Datei umbennen zu process-user?


//Überprüfung der Eingabedaten
    include('check-inputs.php'); 
    /*$get_checked = check_get($_GET);
    $post_checked = check_get($_POST);*/
    $request_checked = check_inputs($_REQUEST);


//Geschäftslogik der Verwaltung von Usern
    
    //session starten
    ini_set( 'session.use_cookies', 1 );
    ini_set( 'session.use_only_cookies', 0 );
    ini_set( 'session.use_trans_sid', 1 );
    session_start();  


    //Einbindung des DAO
    include('dao-user.php'); 
    $UserDAO = new SQLiteUserDAO();

    
    //Login
    if ( isset( $request_checked['login'] ) ) {
        
        //Aufruf von loginUser() des UserDAO
        $user = $UserDAO->loginUser($request_checked['email'], $request_checked['passwort']);
        
        //Login erfolgreich und auszugebende Userdaten als Array erhalten
        if( $user != NULL ){            
            $_SESSION["login"] = "success";
            $_SESSION["eingeloggt"] = "true";
            
            
            //Alle unkritischen infos des Users in Session zwischenspeichern
            foreach ($user as $index => $value){
                if( $index != "id" && $index != "password" ){
                    $_SESSION[$index] = htmlspecialchars($value);
                }
            }
            

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
    if ( isset( $request_checked['updaten']) && isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {
        
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
            $succes = $UserDAO->registerUser($request_checked);

            /* Dibo: Entweder ihr implementiert die Registrierung durch versenden von E-Mails oder um das immer wieder aufkommende Problem mit Mails und Mail-Servern zu umgehen, simuliert ihr es wie folgt: Nach dem Registrieren wird keine echte E-Mail verschickt, sondern es kommt der Hinweis: „Es wurde eine E-Mail an die angegebene Adresse verschickt mit weiteren Infos.“ + Link zu einer (temporären) txt-Datei, wo der E-Mail-Text drin steht. -> umsetzung fehlt noch */        

            if( $succes == true ){            
                $_SESSION["registrierung"] = "success"; 
            }
            else{
                $_SESSION["registrierung"] = "db_fail"; //später genauere unterscheidungen

            }
        }
        else{
            $_SESSION["registrierung"] = "pw_fail";
        }
        
        header( 'location: ../login.php' );
        exit;        
    }

    
    //User löschen


//Erzeugung von Ausgabedaten?



//Unerlaubter oder fehlerhafter Aufruf -> Weiterleitung zum Index
header( 'location: ../index.php' );
exit;


?>

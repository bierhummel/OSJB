<?php

//session starten
ini_set( 'session.use_cookies', 1 );
ini_set( 'session.use_only_cookies', 0 );
ini_set( 'session.use_trans_sid', 1 );
session_start();  

//Abmelden
if ( isset ($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) {

    echo "test";
    
    session_unset();
    session_destroy();
    setcookie ( session_name(), "", 1, "/");

    header( 'location: ../index.php' );
    exit;
}


?>
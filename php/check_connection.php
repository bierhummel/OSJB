<?php 


$database = "../database/database.db";

//Laut Dokumentation von pdo/sqlite3 wird eine neue db bei Objekterstellung erzeugt.
//Wird getestet
 $db = new PDO('sqlite:' . $database);
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 try{    
 $db->exec("create table if not exists user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, plz text, verified integer NOT NULL, mail_verified integer NOT NULL)");
 $db->exec("create table if not exists jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, beschreibung text, art text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, logo blob, link text, beschaeftigungsbeginn text, FOREIGN KEY (user_id) REFERENCES user(id))");}
    catch(PDOException $e) {
    // Zeige PDOException message
    echo $e->getMessage();
  }

// Überprüfen der Rechte
if (!is_writable($database)) {
 // Wenn nicht vorhanden, Schreibrechte setzen
 chmod($datenbank, 0777);
}    
// Fehlermeldungen
error_reporting(E_ALL);
ini_set('display_errors', true);        



?>
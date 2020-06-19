<?php 

$database = "../database/database.db";

// Es wird bei Nichtbestand der DB eine neue Datenbank erzeugt, wenn Skript ausgeführt wird.
$db = new PDO('sqlite:' . $database);
// Errormode wird angemacht, um potentielle Fehler nachvollziehen zu können
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
try{
 //Kreieren der Tables User und Jobangebot    
 $db->exec("create table user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, plz text, stadt text, verified integer NOT NULL, mail_verified integer NOT NULL)");
 $db->exec("create table jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, stadt text, beschreibung text, art text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, logo blob, link text, beschaeftigungsbeginn text, FOREIGN KEY (user_id) REFERENCES user(id))");
 
 $register = "insert into user (uname, vname, nname, password, mail, strasse, hausnr, plz, stadt) values (:uname, :vname, :nname, :password, :mail, :hausnr, :plz, :stadt))";
 $uname = "OSJB AG";
 $vname = "Stefan";    
 $nname = "Schröder";    
 $password = password_hash("12345678asdf", PASSWORD_DEFAULT);
 $mail = "stefan-schroeder@osjb.de";    
 $strasse = "An der großen Eiche";
 $hausnr = "41a-d";
 $plz = "33602";
 $stadt = "Bielefeld";    
 $verified = 1;
 $mail_verified = 1;
    
 $stmt = $db->prepare($register);
 // Binde die Parameter an die Variablen,
 $stmt->bindParam(':uname', $uname);  
 $stmt->bindParam(':vname', $vname);
 $stmt->bindParam(':nname', $nname);    
 $stmt->bindParam(':mail', $mail);
 $stmt->bindParam(':password', password);
 $stmt->bindParam(':strasse', $strasse);
 $stmt->bindParam(':hausnr', $hausnr);
 $stmt->bindParam(':plz', $strasse);
 $stmt->bindParam(':stadt', $stadt);      
 $stmt->bindParam(':verified', $verified);
 $stmt->bindParam(':mail_verified', $mail_verified);
 // Und führe die Transaktion letzlich aus.
 $stmt->execute();
     
 $register1 = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt beschreibung, art, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn) values (1, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn)";

    $status = 0;
    $titel = "Jobangebot 1";
    $strasse = "Carl-von-Ossietzky-Straße";
    $hausnr = 32;
    $plz = "21335";
    $stadt = "Lüneburg";
    $beschreibung = "Ein Testangebot nur für Sie!";
    $art = "Vollzeit";
    $im_bachelor = 0;
    $bachelor = 0;
    $im_master = 0;
    $master = 1;
    $ausbildung = 0;
    $fachrichtung = "Informatik";
    $link = "https://www.osjb.de/";
    $beschaeftigungsbeginn = "20.07.2020";
    
    $stmt = $db->prepare($register);    
    $stmt->bindParam(':status', $status);  
    $stmt->bindParam(':titel', $titel);
    $stmt->bindParam(':strasse', $strasse);    
    $stmt->bindParam(':hausnr', $hausnr);
    $stmt->bindParam(':plz', $strasse);
    $stmt->bindParam(':stadt', $stadt);      
    $stmt->bindParam(':beschreibung', $beschreibung);
    $stmt->bindParam(':art', $art);   
    $stmt->bindParam(':im_bachelor', $im_bachelor);  
    $stmt->bindParam(':bachelor', $bachelor);
    $stmt->bindParam(':im_master', $im_master);    
    $stmt->bindParam(':master', $master);    
    $stmt->bindParam(':ausbildung', $ausbildung);
    $stmt->bindParam(':fachrichtung', $fachrichtung);    
    $stmt->bindParam(':link', $link);       
    $stmt->bindParam(':beschaeftigungsbeginn', $beschaeftigungsbeginn);  
    
     $stmt->execute();
}
    catch(PDOException $e) {
    // Zeige PDOException message
    echo $e->getMessage();
  }

// Überprüfen der Rechte
if (!is_writable($database)) {
 // Wenn nicht vorhanden, Schreibrechte setzen
 chmod($database, 0777);
}    
// Fehlermeldungen
error_reporting(E_ALL);
ini_set('display_errors', true);        



?>
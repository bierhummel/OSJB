<?php 

/************************************************
/* Klasse fürs Überprüfen der Datenbank         *
*  Ist keine DB vorhanden, wird eine erstellt   *
*  Es werden Testdaten in die DB eingetragen    *
************************************************/


$database = "database/database.db";
$file_existed = false;



if (file_exists($database)) {
    $file_existed = true;
}

// Es wird bei Nichtbestand der DB eine neue Datenbank erzeugt, wenn Skript ausgeführt wird.
$db = new PDO('sqlite:' . $database);

// Errormode wird angemacht, um potentielle Fehler nachvollziehen zu können
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
try{
    //Kreieren der Tables User und Jobangebot    
    $db->exec("create table if not exists user (id integer primary key, uname text NOT NULL, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, strasse text, hausnr text, plz text, stadt text, verified integer NOT NULL, mail_verified integer NOT NULL)");
    
    $db->exec("create table if not exists jobangebot (id integer primary key, user_id integer, status integer NOT NULL, titel text, strasse text, hausnr text, plz text, stadt text, beschreibung text, art text, zeitintensitaet text, im_bachelor integer NOT NULL, bachelor integer NOT NULL, im_master integer NOT NULL, master integer NOT NULL, ausbildung integer NOT NULL, fachrichtung text, logo blob, link text, beschaeftigungsbeginn text, erstellt_am integer, FOREIGN KEY (user_id) REFERENCES user(id))");

    //Wenn es vorher keine DB gab: 
    //Erstellung von 3 Testunternehmen und 4 Testjobangeboten dieser Unternehmen
    if (!$file_existed){ 
        
        //Firma1
        $unternehmen = "insert into user (uname, vname, nname, password, mail, strasse, hausnr, plz, stadt, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :strasse, :hausnr, :plz, :stadt, :verified, :mail_verified)";    

        $uname = "OSJB AG";
        $vname = "Stefan";    
        $nname = "Schröder"; 
        $password = password_hash("12345678asdf", PASSWORD_DEFAULT);
        $mail = "stefan-schroeder@osjb.de";    
        $strasse = "An der großen Eiche";
        $hausnr = "41a-d";
        $plz = "26129";
        $stadt = "Oldenburg";    
        $verified = 1;
        $mail_verified = 1;

        $stmt = $db->prepare($unternehmen);
        // Binde die Parameter an die Variablen,
        $stmt->bindParam(':uname', $uname);  
        $stmt->bindParam(':vname', $vname);
        $stmt->bindParam(':nname', $nname);    
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':strasse', $strasse);
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
        $stmt->bindParam(':stadt', $stadt);      
        $stmt->bindParam(':verified', $verified);
        $stmt->bindParam(':mail_verified', $mail_verified);
        // Und führe die Transaktion letzlich aus.
        $stmt->execute();

        
        //Firma2
        $unternehmen1 = "insert into user (uname, vname, nname, password, mail, strasse, hausnr, plz, stadt, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :strasse, :hausnr, :plz, :stadt, :verified, :mail_verified)";    

        $uname = "EWE AG";
        $vname = "Max";    
        $nname = "Mustermann"; 
        $password = password_hash("asdfghjkl", PASSWORD_DEFAULT);
        $mail = "max-mustermann@ewe.de";    
        $strasse = "Tirpitzstraße";
        $hausnr = "39";
        $plz = "26122";
        $stadt = "Oldenburg";    
        $verified = 0;
        $mail_verified = 1;

        $stmt = $db->prepare($unternehmen1);
        // Binde die Parameter an die Variablen,
        $stmt->bindParam(':uname', $uname);  
        $stmt->bindParam(':vname', $vname);
        $stmt->bindParam(':nname', $nname);    
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':strasse', $strasse);
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
        $stmt->bindParam(':stadt', $stadt);      
        $stmt->bindParam(':verified', $verified);
        $stmt->bindParam(':mail_verified', $mail_verified);
        // Und führe die Transaktion letzlich aus.
        $stmt->execute();  

        
        //Firma3
        $unternehmen2 = "insert into user (uname, vname, nname, password, mail, strasse, hausnr, plz, stadt, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :strasse, :hausnr, :plz, :stadt, :verified, :mail_verified)";    

        $uname = "Telekom Deutschland GmbH";
        $vname = "Judith";    
        $nname = "Möller"; 
        $password = password_hash("qwertz12345", PASSWORD_DEFAULT);
        $mail = "judith-moeller@t-online.de";    
        $strasse = "Landgrabenweg";
        $hausnr = "141";
        $plz = "53227";
        $stadt = "Bonn";    
        $verified = 1;
        $mail_verified = 1;

        $stmt = $db->prepare($unternehmen2);
        // Binde die Parameter an die Variablen,
        $stmt->bindParam(':uname', $uname);  
        $stmt->bindParam(':vname', $vname);
        $stmt->bindParam(':nname', $nname);    
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':strasse', $strasse);
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
        $stmt->bindParam(':stadt', $stadt);      
        $stmt->bindParam(':verified', $verified);
        $stmt->bindParam(':mail_verified', $mail_verified);
        // Und führe die Transaktion letzlich aus.
        $stmt->execute();      


        //Erstellung der Jobs   
        //Job1
        $job = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn, erstellt_am) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn, datetime('now'))";
        $uid = 1;
        $status = 0;
        $titel = "Praktikum Webprogrammierung";
        $strasse = "Carl-von-Ossietzky-Straße";
        $hausnr = "32";
        $plz = "26129";
        $stadt = "Oldenburg";
        $beschreibung = "Ein Testangebot nur für Sie!";
        $art = "Praktikum";
        $im_bachelor = 0;
        $bachelor = 0;
        $im_master = 0;
        $master = 1;
        $ausbildung = 0;
        $fachrichtung = "Informatik, Wirtschafts- und Rechtswissenschaften";
        $link = "www.osjb.de";
        $beschaeftigungsbeginn = "2020-06-10";
        $zeitintensitaet = '20h';

        $stmt = $db->prepare($job);
        $stmt->bindParam(':uid', $uid); 
        $stmt->bindParam(':status', $status);  
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':strasse', $strasse);    
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
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
        $stmt->bindParam(':zeitintensitaet', $zeitintensitaet);  
        $stmt->execute();

        
        //Job2
        $job1 = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn, erstellt_am) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn, datetime('now'))";

        $uid = 2;
        $status = 1;
        $titel = "Studentische Hilfskraft Controlling";
        $strasse = "Theodorstraße";
        $hausnr = "17";
        $plz = "53426";
        $stadt = "Schalkenbach";
        $beschreibung = "Wir suchen dich.";
        $art = "Werkstudent";
        $im_bachelor = 1;
        $bachelor = 0;
        $im_master = 1;
        $master = 0;
        $ausbildung = 0;
        $fachrichtung = "Informatik, Wirtschafts- und Rechtswissenschaften";
        $link = "www.ewe.com/de/karriere/studenten-und-absolventen/werkstudententaetigkeit";
        $beschaeftigungsbeginn = "2020-06-10";
        $zeitintensitaet = 'Vollzeit';

        $stmt = $db->prepare($job1);  
        $stmt->bindParam(':uid', $uid);  
        $stmt->bindParam(':status', $status);  
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':strasse', $strasse);    
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
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
        $stmt->bindParam(':zeitintensitaet', $zeitintensitaet); 
        $stmt->execute();

        
        //Job3
        $job2 = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn, erstellt_am) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn, datetime('now'))";

        $uid = 2;
        $status = 1;
        $titel = "Aushilfe im Bereich Telekommunikation";
        $strasse = "Mühlenweg";
        $hausnr = "43b";
        $plz = "06198";
        $stadt = "Salzatal";
        $beschreibung = "Erlebe mit uns Sachen, die ohne uns eventuell langweilig wären.";
        $art = "Aushilfe";
        $im_bachelor = 0;
        $bachelor = 1;
        $im_master = 0;
        $master = 1;
        $ausbildung = 1;
        $fachrichtung = "Informatik, Wirtschafts- und Rechtswissenschaften";
        $link = "www.ewe-salzatal.de";
        $beschaeftigungsbeginn = "2020-06-10";
        $zeitintensitaet = 'Teilzeit';
        

        $stmt = $db->prepare($job2);   
        $stmt->bindParam(':uid', $uid);  
        $stmt->bindParam(':status', $status);  
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':strasse', $strasse);    
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
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
        $stmt->bindParam(':zeitintensitaet', $zeitintensitaet); 
        $stmt->execute();

        
        //Job4
        $job3 = "insert into jobangebot (user_id, status, titel, strasse, hausnr, plz, stadt, beschreibung, art, zeitintensitaet, im_bachelor, bachelor, im_master, master, ausbildung, fachrichtung, link, beschaeftigungsbeginn, erstellt_am) values (:uid, :status, :titel, :strasse, :hausnr, :plz, :stadt, :beschreibung, :art, :zeitintensitaet, :im_bachelor, :bachelor, :im_master, :master, :ausbildung, :fachrichtung, :link, :beschaeftigungsbeginn, datetime('now'))";

        $uid = 3;
        $status = 1;
        $titel = "Minijob für einfache Programmiertätigkeiten";
        $strasse = "Fliederallee";
        $hausnr = 31;
        $plz = "68159";
        $stadt = "Mannheim";
        $beschreibung = "Wir suchen genau dich, damit uns hilfst, erfolgreicher zu werden.";
        $art = "Minijob";
        $im_bachelor = 1;
        $bachelor = 0;
        $im_master = 1;
        $master = 0;
        $ausbildung = 0;
        $fachrichtung = "Informatik, Wirtschafts- und Rechtswissenschaften";
        $link = "www.telekom-in-mannheim.de";
        $beschaeftigungsbeginn = "2020-06-10";
        $zeitintensitaet = '20h';
        

        $stmt = $db->prepare($job3);  
        $stmt->bindParam(':uid', $uid);  
        $stmt->bindParam(':status', $status);  
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':strasse', $strasse);    
        $stmt->bindParam(':hausnr', $hausnr);
        $stmt->bindParam(':plz', $plz);
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
        $stmt->bindParam(':zeitintensitaet', $zeitintensitaet); 
        $stmt->execute();    
    }
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
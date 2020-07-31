<?php
//Hochgeladenes Bild einfügen
//Orientiert an https://www.w3schools.com/php/php_file_upload.asp
//und https://www.html.de/threads/bilder-upload-exif-imagetype.57990/

function fileUpload( $files ){
    
    $upload_folder = '../uploads/'; //Das Upload-Verzeichnis für diese Funktion
    $upload_folder_return = "uploads/"; //Das Upload-Verzeichnis für Rückgabe
    $file = $files['new_logo']['name']; //Hochgeladene Datei
    $filepath = $upload_folder . $file; //Pfad wo Datei hin soll
    $filepath_return = $upload_folder_return . $file; //Pfad für Rückgabe
    $filename = strtolower( pathinfo($file, PATHINFO_FILENAME) ); //Dateiname ohne Dateityp
    $fileType = strtolower( pathinfo($file, PATHINFO_EXTENSION) ); //Dateityp

    //Überprüfung der Dateiendung
    $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
    if( !in_array( $fileType, $allowed_extensions) ) {
        $_SESSION["fileUpload"] = "Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt.";
        return null;
    }
    
    //Überprüfung, dass das Bild wirklich ein Bild ist
    if( getimagesize($files['new_logo']['tmp_name']) === false ) {
        $_SESSION["fileUpload"] = "Nur der Upload von Bilddateien ist gestattet.";
        return null;
    }

    //Überprüfung der Dateigröße
    $max_size = 1000000; //1 MB
    if($files['new_logo']['size'] > $max_size) {
        $_SESSION["fileUpload"] = "Bitte keine Dateien größer als 1MB hochladen.";
        return null;
    }

    //Neuer Dateiname falls Dateiname bereits vergeben
    if( file_exists($filepath) ) { 
        $id = 1;
        
        //Falls Datei existiert, hänge eine Zahl an den Dateinamen, bis freier Name gefunden
        do {
            $filepath = $upload_folder.$filename.'-'.$id.'.'.$fileType;
            $id++;
        } while(file_exists($filepath));
    }

    //Alles okay, verschiebe Datei an neuen Pfad
    move_uploaded_file($files['new_logo']['tmp_name'], $filepath);
    
    //Verschieben erfolgreich
    if( file_exists($filepath) ) {
        $_SESSION["fileUpload"] = "Bild erfolgreich hochgeladen.";
        return $filepath_return;
    }
    //Update nicht erfolgreich
    else{
        $_SESSION["fileUpload"] = "Upload fehlgeschlagen. Probieren Sie es bitte erneut.";
        return null;
    } 
}
    

?>
<?php
//Datei mit ausgelagerter Funktion zur Überprüfung von Usereingaben aller Art im Hinblick auf XSS

function check_inputs($input = array()){
    $checked = array();
    
    foreach($input as $index => $value){        
        if (isset($value) && is_string($value)){
            
            $temp = array(htmlspecialchars($index) => htmlspecialchars($value));
            $checked = array_merge($checked, $temp);
            
        }
        else{
            $temp = array(htmlspecialchars($index) => "");
            $checked = array_merge($checked, $temp);            
        }
        
    }
    return $checked;
}
    

//Unerlaubter oder fehlerhafter Aufruf?


?>
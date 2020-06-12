<?php
ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();


$name = (isset($_POST["name"]) && is_string($_POST["name"]))
? $_POST["name"] : "";
           
$email1 = (isset($_POST["email1"]) && is_string($_POST["email1"]))
? $_POST["email1"] : "";
            
$passwort1 = (isset($_POST["passwort1"]) && is_string($_POST["passwort1"]))
? $_POST["passwort1"] : "";
 $passwort2 = (isset($_POST["passwort2"]) && is_string($_POST["passwort2"]))
? $_POST["passwort2"] : "";

$unv = (isset($_POST["unv"]) && 
       is_string($_POST["unv"])) ? $_POST["unv"] : "";
   
$name = htmlspecialchars($name);
$email1 = htmlspecialchars($email1);
$passwort1 = htmlspecialchars($passwort1);
$passwort2 = htmlspecialchars($passwort2);
$unv = htmlspecialchars($unv);
      
            if ($_POST['passwort1']!= $_POST['passwort2'])
 {
     echo("Passwort nicht übereinstimmen! Versuchen Sie es erneut. ");
 }
                             $namedummy = "wael";
                                  $emaildummy = "wael.hikal@uol.de";
                            if ($email1 == $emaildummy and $name == $namedummy){
                                
                                     echo("Name oder Email ist bereits vorhanden ");

                            }
        
 if ($passwort1 == $passwort2 and $email1 != $emaildummy and $name != $namedummy )
 {
                                        
                                        return true;

        } 
       else {
                                                
                                                return false;

       }
                        
            

?>

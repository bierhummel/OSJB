<?php

/*alt -> vor abgabe löschen?

ini_set("session.use_cookies", 1); 
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();

include('dao-user.php'); 
$user = new Userimp();

if(isset($_POST['ab'])){

$name = (isset($_POST["name"]) && is_string($_POST["name"]))
? $_POST["name"] : "";
           
$email = (isset($_POST["email"]) && is_string($_POST["email"]))
? $_POST["email"] : "";
            
$passwort = (isset($_POST["passwort"]) && is_string($_POST["passwort"]))
? $_POST["passwort"] : "";
 $straße = (isset($_POST["straße"]) && is_string($_POST["straße"]))
? $_POST["straße"] : "";
                
$plz = (isset($_POST["plz"]) && is_string($_POST["plz"]))
? $_POST["plz"] : "";
$stadt = (isset($_POST["stadt"]) && is_string($_POST["stadt"]))
? $_POST["stadt"] : "";
    
    
$user->update($name,$email,$passwort1);


   
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$passwort = htmlspecialchars($passwort);
$straße = htmlspecialchars($straße);
$plz = htmlspecialchars($plz);
$stadt = htmlspecialchars($stadt);

    echo " Änderungen wurden vorgenommen";
}

            
*/           
?>

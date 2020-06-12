<?php

if(isset($_POST['reg'])){

$name = (isset($_POST["name"]) && is_string($_POST["name"]))
? $_POST["name"] : "";
           
$email = (isset($_POST["email1"]) && is_string($_POST["email1"]))
? $_POST["email1"] : "";
            
$password = (isset($_POST["passwort1"]) && is_string($_POST["passwort1"]))
? $_POST["passwort1"] : "";
   
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$password = htmlspecialchars($password);
        console.log("sadff");
        $db = new SQLite3('../database/database.db'); 
         $db->exec("INSERT INTO users(name, email, password) VALUES ('$name','$email', '$password')"); 
   }
?>

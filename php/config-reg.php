<?php

ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);

session_start();
include('dao-user.php'); 

$user = new Userimp();

if(isset($_POST['reg'])){

$name = (isset($_POST["name"]) && is_string($_POST["name"]))
? $_POST["name"] : "";

$email1 = (isset($_POST["email1"]) && is_string($_POST["email1"]))
? $_POST["email1"] : "";

$passwort1 = (isset($_POST["passwort1"]) && is_string($_POST["passwort1"]))
? $_POST["passwort1"] : "";
    
$hashed_passwort1 = password_hash($passwort1, PASSWORD_DEFAULT);    
    
$passwort2 = (isset($_POST["passwort2"]) && is_string($_POST["passwort2"]))
? $_POST["passwort2"] : "";

$hashed_passwort2 = password_hash($passwort2, PASSWORD_DEFAULT);      
    
$unv = (isset($_POST["unv"]) &&
is_string($_POST["unv"])) ? $_POST["unv"] : "";
    
    
$user->save($name,$email1,$passwort1);

    
if (!($user->checkIfExists($name,$email1,$passwort1))){

    echo("Unter dieser Mail-Adresse ist bereits eine Person registriert.");
    //TODO: Passwort vergessen? 
    return;
    }
 

            
            if ($passwort1 == $passwort2)
            {
              $user->register_in_db($name,$email1,$hashed_passwort1);
                echo("Willkommen");
            header("location: ../profil.php");

            }
            else {
            echo("Name oder Email ist bereits vorhanden ");

            }

            }


if(isset($_POST['log'])){

$email = (isset($_POST["email"]) && is_string($_POST["email"]))
? $_POST["email"] : "";
$passwort = (isset($_POST["passwort"]) && is_string($_POST["passwort"]))
? $_POST["passwort"] : "";
$ckbox = (isset($_POST["ckbox"]) && is_string($_POST["ckbox"])) ? $_POST["ckbox"] : "";


$ckbox = htmlspecialchars($ckbox);
$email = htmlspecialchars($email);
    
$user->load($email,$passwort);

if ($email == $emaildummy and $passwort == $passdummy){
if ( isset($_POST['ckbox'])){
setcookie('email', $email, time()+60*60*7);

}
                    session_start();
$_SESSION['email']= $email;
    echo "Willkommen";

header("location: ../profil.php");


}else{ echo "email oder passwort ist ungültig ";}
}
    
           
?>

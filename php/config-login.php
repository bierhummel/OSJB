<?php
include('php/dao-user.php');

$emaildummy = "wael.hikal@uol.de";
$passdummy = "12345678";

if(isset($_POST['log'])){

$email = (isset($_POST["email"]) && is_string($_POST["email"]))
? $_POST["email"] : "";
$passwort = (isset($_POST["passwort"]) && is_string($_POST["passwort"]))
? $_POST["passwort"] : "";
$ckbox = (isset($_POST["ckbox"]) && is_string($_POST["ckbox"])) ? $_POST["ckbox"] : "";


$ckbox = htmlspecialchars($ckbox);
$email = htmlspecialchars($email);
$passwort = htmlspecialchars($passwort);
if ($email == $emaildummy and $passwort == $passdummy){
if ( isset($_POST['ckbox'])){
setcookie('email', $email, time()+60*60*7);
setcookie('passwort', $passwort, time()+60*60*7);

}
                    session_start();
$_SESSION['email']= $email;
header("location: ../profil.php");
echo "Willkommen";


}else{ echo "email oder passwort ist ungültig ";}
}
           
?>

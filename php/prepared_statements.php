<?php



class prepared_statements{
    
         public function addUser($username, $email, $password) {
            ini_set("session.use_cookies", 1); 
             ini_set("session.use_only_cookies", 0);
             ini_set("session.use_trans_sid", 1);

             session_start();

   if(isset($_POST['reg'])){

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
$email = htmlspecialchars($email1);
$password = htmlspecialchars($passwort1);
   
         $db = new SQLite3('../database/database.db'); 
         // SQL-Befehl
         $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
 
         $statement = $db->connect()->prepare($sql);
 
         $statement->bindValue(':name', $name);
         $statement->bindValue(':email', $email);
         $statement->bindValue(':password', $password);
 
         $inserted = $statement->execute();
 
         // echo ob User eingetragen wurde
         if ($inserted) {
        echo "Der User wurde eingetragen.";
         } else {
        echo "Der User wurde nicht eingetragen.";
         }
     }}
}
?>

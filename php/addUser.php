<?php

if(isset($_POST['reg'])){
if(include('config-reg.php')){
    
$name = (isset($_POST["name"]) && is_string($_POST["name"]))
? $_POST["name"] : "";
           
$email = (isset($_POST["email1"]) && is_string($_POST["email1"]))
? $_POST["email1"] : "";
            
$password = (isset($_POST["passwort1"]) && is_string($_POST["passwort1"]))
? $_POST["passwort1"] : "";
   
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$password = htmlspecialchars($password);
    try{
    $database = "../database/database.db";
    $file_db = new PDO('sqlite:' . $database); 
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
    $file_db->exec("CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY, 
                    name TEXT, 
                    email TEXT,
                    password TEXT)");
     
    $insert = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)";
    $stmt = $file_db->prepare($insert);
 
    // Bind parameters to statement variables
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    header("location: ../profil.php");
    
   } catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

}
}
else {
    echo("Name oder Email ist bereits vorhanden ");
}
?>


<?php

 

class prepared_statements{
    
     public function addUserDummy() {
         $db = new SQLite3('../database/database.db');
         $name = "Testuser";
         $email = "test@email.com";
         $password = "123456";
 
         // SQL-Befehl
         $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
 
         $statement = $db->connect()->prepare($sql);
 
         $statement->bindValue(':username', $username);
         $statement->bindValue(':email', $email);
         $statement->bindValue(':password', $password);
 
         $inserted = $statement->execute();
 
         // echo ob User eingetragen wurde
         if ($inserted) {
        echo "Der User wurde eingetragen.";
         } else {
        echo "Der User wurde nicht eingetragen.";
         }
     }
    
         public function addUser($username, $email, $password) {
         $db = new SQLite3('../database/database.db'); 
         // SQL-Befehl
         $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
 
         $statement = $db->connect()->prepare($sql);
 
         $statement->bindValue(':username', $username);
         $statement->bindValue(':email', $email);
         $statement->bindValue(':password', $password);
 
         $inserted = $statement->execute();
 
         // echo ob User eingetragen wurde
         if ($inserted) {
        echo "Der User wurde eingetragen.";
         } else {
        echo "Der User wurde nicht eingetragen.";
         }
     }
}
?>

<?php 
 class Benutzer
 {
 private $email;
 private $name;
 private $password;
     
 public function getName()
 {
 return $this->name;
 }

 public function setName($name)
 {
 $this->_name = $name;
 }
 public function getEmail()
 {
 return $this->email;
 }

 public function setEmail($email)
 {
 $this->email = $email;
 }
 public function getPassword()
 {
 return $this->password;
 }

 public function setPassword($password)
 {
 $this->password = $password;
 }


 }
 interface DAO {
 public function update($name,$email,$password);
 public function save($name,$email,$password);
 public function load($email,$password);
 }

class Userimp implements DAO {

    
public function load($email,$password) {
$u = new Benutzer();
$email =$u->getEmail();
$password =$u->getPassword();
}
public function save($name,$email,$password){
    
$x = new Benutzer();
    
$x->setEmail($email);
$x->setName($name);
$x->setEmail($password);  

}
    
public function checkIfExists($name,$email,$password){ 
$database = "../database/database.db";
$file_db = new PDO('sqlite:' . $database);
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
 $file_db->exec("create table if not exists user (id integer primary key, vname text NOT NULL, nname text NOT NULL, password text NOT NULL, mail text NOT NULL, uname text, strasse text, hausnr text, plz text, verified integer NOT NULL, mail_verified integer NOT NULL);");
 
 $exists = "select count(*) from user where mail = :mail";
 $stmt = $file_db->prepare($exists);
 $stmt->bindParam(':mail', $email);
 $stmt->execute();
 $count = $stmt->fetchColumn();
 $count = intval($count);
 if ($count == 0){
     return true;
 }
        else {
            return false;
        }
        
} catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
}

public function register_in_db ($vname,$email,$password)  {
 $nname= "Nachname";       
//TODO: VOR UND NACHNAME UEBERGEBEN
$database = "../database/database.db";
$file_db = new PDO('sqlite:' . $database);
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
    
 $register = "insert into user (nname, vname, password, mail, verified, mail_verified) VALUES (:nname,:vname,:password,:mail,0,0)";
 $stmt = $file_db->prepare($register);
 
 $stmt->bindParam(':nname', $nname);    
 $stmt->bindParam(':vname', $vname);
 $stmt->bindParam(':mail', $email);
 $stmt->bindParam(':password', $password);
 $stmt->execute();
    
} catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
}   

    
public function update($name,$email,$password){
$y = new Benutzer();
 $y-> getEmail($email);
 $y-> getName($name);
 $y-> getPassword($password);
    
}
}
                

    
?>

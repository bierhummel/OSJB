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
public function update($name,$email,$password){
$y = new Benutzer();
 $y-> getEmail($email);
 $y-> getName($name);
 $y-> getPassword($password);
    
}
}
                

    
?>

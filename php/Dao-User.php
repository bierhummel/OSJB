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

 public function __construct(){
 $this->email =em;
 $this->name = na;
 $this->password = pass;
 }
 }
 interface DAO {
 public function update(Benutzer $user);
 public function save(Benutzer $user);
 public function load(Benutzer $user);
 }

class Benutzerimp implements DAO {
public function load(Benutzer $u) {
$emailm =$u->setEmail();
$passwordm =$u->setPassword();
}
public function save(Benutzer $u){
$u = new Benutzer();
$emaile =$u->setEmail();
$namee =$u->setName();
$passworde =$u->setEmail();
}
public function update(Benutzer $u){
$u = new Benutzer();
$emailu = $u-> setEmail();
$nameu = $u-> setName();
$passwordu = $u-> setPassword();
}
}
        
        

    
?>

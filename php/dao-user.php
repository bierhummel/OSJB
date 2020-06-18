<?php

include('connect.php');

/*
class Benutzer {
    private $email;
    private $name;
    private $password;

    public function getName() {
        return $this->name;
    }

    public function setName( $name ) {
        $this->_name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail( $email ) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword( $password ) {
        $this->password = $password;
    }

}
*/

interface UserDAO {
    public function loginUser( $email, $password );
    
    public function updateUser( $user );

    public function registerUser( $user );
    
    public function deleteUser(  $user_id, $password );
    
    //public function activateUser(); Übergangsweise neuer Benutzer direkt aktiv
}

class SQLiteUserDAO implements UserDAO {
    //Verbindung zur DB neu bei jeder Anfrage oder beim Erstellen des Objekts im Konstruktor?
    private $db = new Connection->getDatabase();
    
    public function loginUser( $email, $password ){
        
        $user_id = null; //Array mit allen wichtigen Informationen des Users (z.b. kein PW und Logo)
        
        /*test*/
        $user_id = array("id" => 0, "vorname" => "abc", "nachname" => "jas");
        
        
        return $user_id;
    }
    
    
    
    public function updateUser( $User ){
        $user_id = null; //Array mit aktualisierten wichtigen Informationen des Users (z.b. kein PW und Logo)
        
        /*test*/
        $user_id = array("id" => 0, "vorname" => "test", "nachname" => "jas");
        
        
        return $user_id;
        
    }

    public function registerUser( $User ){
        //Die Prepared Statements auslagern oder drin behalten?
        $succes = false;
        
        //Wie komme ich nun an die Inputs?
        $uname = 'Test AG';
        $vname = 'Dieter';
        $nname = 'Schröder';
        $password = '12345678';
        $mail = '12345@gmx.de';
        $verified = 0;
        $mail_verified = 0;
        
        
        if (!UserAlreadyExists($email)){
            try{
                $register = "insert into user (uname, vname, nname, password, mail, verified, mail_verified) values (:uname, :vname, :nname, :password, :mail, :verified, :mail_verified)";
                $stmt = this->$db->prepare($register);
                $stmt->bindParam(':uname', $uname);  
                $stmt->bindParam(':vname', $vname);
                $stmt->bindParam(':nname', $nname);    
                $stmt->bindParam(':mail', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':verified', $verified);
                $stmt->bindParam(':verified', $mail_verified);
                $stmt->execute();
                $succes = true;
                
} catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    $success = false;
  }

        } else {
            $success = false;
        }
            return $succes;  
          
    }
    
    public function deleteUser(  $user_id, $password ){}
    
    private function UserAlreadyExists( $mail ){
    try{
            $exists = "select count(*) from user where mail = :mail";
            $stmt = this->$db->prepare($exists);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $count = intval($count);
            if ($count == 0){
                return false;
        }
            else {
                return true;
        }
        
} catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
    }
    
}


/*
class DummyUserDAO implements UserDAO {

    public function load( $email, $password ) {
        $u = new Benutzer();
        $email = $u->getEmail();
        $password = $u->getPassword();
    }

    public function save( $name, $email, $password ) {

        $x = new Benutzer();

        $x->setEmail( $email );
        $x->setName( $name );
        $x->setEmail( $password );

    }

    public function update( $name, $email, $password ) {
        $y = new Benutzer();
        $y-> getEmail( $email );
        $y-> getName( $name );
        $y-> getPassword( $password );
    }
}
*/


//Unerlaubter oder fehlerhafter Aufruf?


?>
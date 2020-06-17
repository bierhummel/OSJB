<?php

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
    
    public function loginUser( $email, $password ){
        $user_id = null; //Array mit allen wichtigen Informationen des Users (z.b. kein PW und Logo)
        
        /*test
        $user_id = array("id" => 0, "vorname" => "abc", "nachname" => "jas");
        */
        
        return $user_id;
    }
    
    
    
    public function updateUser( $User ){}

    public function registerUser( $User ){
        $succes = false;
        
        
        return $succes;        
    }
    
    public function deleteUser(  $user_id, $password ){}
    
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

?>
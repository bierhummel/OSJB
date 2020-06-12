<?php
    /*
    * SQLite3 Einstellungen, Verbindung erstellen - sql_connector.php
    */
    
class sql_connector {
 
    /**
     * Aufbau der Datenbankverbindung mit PDO
     */
    
    public function connect() {
 
        try {
            $datasource = "mysql:host=localhost;dbname=database";
            return new \PDO($datasource, "root", "root");
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
            die();
        }
    }
 
}
    ?>
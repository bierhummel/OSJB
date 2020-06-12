<?php
     /***************************************************************
    * This script adds default users to the database                *
    * Run this script if the database is empty for some reasons     *
    ****************************************************************/

  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $database = "../database/database.db";
    $file_db = new PDO('sqlite:' . $database); 
      
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 
    /**************************************
    * Create tables                       *
    **************************************/
 
    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY, 
                    name TEXT, 
                    email TEXT,
                    password TEXT)");
 
 
    /**************************************
    * Set initial data                    *
    **************************************/
 
    // Array with some test data to insert to database             
    $messages = array(
                  array('name' => 'wael',
                        'email' => 'wael1@yahoo.de',
                        'password' => 'waelistcool'),
                  array('name' => 'janssen',
                        'email' => 'janssen5@gmail.com',
                        'password' => 'janssenistcool'),
                  array('name' => 'oswald',
                        'email' => 'oswald@gmx.de',
                        'password' => 'oswaldistcool')
                );
 
 
    /**************************************
    * A little bit of binding             *
    **************************************/
 
    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO messages (name, email, password) 
                VALUES (:name, :email, :password)";
    $stmt = $file_db->prepare($insert);
 
    // Bind parameters to statement variables
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
 
    // Loop thru all messages and execute prepared insert statement
    foreach ($users as $user) {
      // Set values to bound variables
      $name = $user['name'];
      $email = $user['email'];
      $password = $user['password'];
 
      // Execute statement
      $stmt->execute();
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
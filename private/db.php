<?php
try{
  $dbUserName = 'admin';
  $dbPassword = 'dFiGAzkQzBnHIlLS';
  $dbConnection = 'mysql:host=localhost; dbname=askIt; charset=utf8mb4'; 
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM
  ];
  $db = new PDO(  $dbConnection, 
                  $dbUserName, 
                  $dbPassword , 
                  $options );
}catch(PDOException $ex){
  echo $ex;
  echo 'error';
  exit;
}
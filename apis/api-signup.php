<?php
try{
  if(empty($_POST['email'])){ sendError(400, 'missing email', __LINE__); }
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ sendError(400, 'email not valid', __LINE__); }
  if(empty($_POST['username'])){ sendError(400, 'missing username', __LINE__); }
  if(strlen($_POST['username']) < 2){ sendError(400, 'username must be at least 2 characters long', __LINE__); }
  if(strlen($_POST['username']) > 20){ sendError(400, 'username cannot be longer than 20 characters', __LINE__); }
  if(empty($_POST['password'])){ sendError(400, 'missing password', __LINE__); }
  if(strlen($_POST['password']) < 6){ sendError(400, 'password must be at least 6 characters long', __LINE__); }
  if(strlen($_POST['password']) > 100){ sendError(400, 'password cannot be longer than 100 characters', __LINE__); }

  require_once(__DIR__.'../../private/db.php');

  $q = $db->prepare('SELECT * FROM users WHERE sEmail = :email LIMIT 1');
  $q->bindValue(':email', $_POST['email']);
  $q->execute();
  $row = $q->fetch();
  if( $row ){
    sendError(400, 'email already registered', __LINE__);
  }

  $q = $db->prepare('SELECT * FROM users WHERE sUserName = :username LIMIT 1');
  $q->bindValue(':username', $_POST['username']);
  $q->execute();
  $row = $q->fetch();
  if( $row ){
    sendError(400, 'username already registered', __LINE__);
  }

  $hashedpw = password_hash( $_POST['password'], PASSWORD_DEFAULT );

  $q = $db->prepare('INSERT INTO users VALUES (:iId, :sEmail, :sUserName, :sPassword)');
  $q->bindValue(':iId', getUuid());
  $q->bindValue(':sEmail', $_POST['email']);
  $q->bindValue(':sUserName', $_POST['username']);
  $q->bindValue(':sPassword', $hashedpw);
  $q->execute();
  $id = $db->lastInsertId();
  http_response_code(200);
  header('Content-Type: application/json');
  echo '{"status":"1","message":"account created","userId":"'.$id.'"}';
  exit;
}catch(PDOException $ex){
  sendError(500, 'system under maintainance', __LINE__);
}

function sendError($iErrorCode, $sMessage, $iLine){
  http_response_code($iErrorCode);
  header('Content-Type: application/json');
  echo '{"message":"'.$sMessage.'", "line":"'.$iLine.'"}';
  exit;
}

function getUuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),
      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,
      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,
      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}
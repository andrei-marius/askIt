<?php
try{
  require_once( __DIR__.'../../private/db.php' );

  $q = $db->prepare('SELECT * FROM users WHERE sEmail = :sEmail LIMIT 1');
  $q->bindValue(':sEmail', $_POST['email']);
  $q->execute();
  $row = $q->fetch();
  if( !$row ){
    sendError(401, 'incorrect email', __LINE__);
  }

  if(password_verify($_POST['password'], $row[3])){
    session_start();
    $_SESSION['userId'] = $row[0];
    $_SESSION['email'] = $row[1];
    $_SESSION['userName'] = $row[2];
    header('Content-Type: application/json');
    echo '{"status":"1","message":"logged in","userId":"'.$_SESSION['userId'].'"}';
    exit;
  }else{
    sendError(401, 'incorrect password', __LINE__);
  }
}catch(Exception $ex){
  sendError(500, 'system under maintainance', __LINE__);
}

function sendError($iResponseCode, $sMessage, $iLine){
  http_response_code($iResponseCode);
  header('Content-Type: application/json');
  echo '{"message":"'.$sMessage.'", "line":"'.$iLine.'"}';
  exit;
}




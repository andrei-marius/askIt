<?php
try{
  session_start();
  if( !$_SESSION ){ sendError('user is not authenticated', __LINE__ ); }
  if(empty($_POST['topicTitle'])){ sendError(400, 'missing title', __LINE__); }
  if(empty($_POST['topicDescription'])){ sendError(400, 'missing description', __LINE__); }

  require_once(__DIR__.'../../private/db.php');

  $q = $db->prepare('SELECT * FROM topics WHERE sTitle = :title LIMIT 1');
  $q->bindValue(':title', $_POST['topicTitle']);
  $q->execute();
  $row = $q->fetch();
  if( $row ){
    sendError(400, 'topic already exists', __LINE__);
  }

  $q = $db->prepare('INSERT INTO topics VALUES (:iId, :iUserIdFk, :sTitle, :sDescription)');
  $q->bindValue(':iId', getUuid());
  $q->bindValue(':iUserIdFk', $_SESSION['userId']);
  $q->bindValue(':sTitle', $_POST['topicTitle']);
  $q->bindValue(':sDescription', $_POST['topicDescription']);
  $q->execute();
  $id = $db->lastInsertId();
  http_response_code(200);
  header('Content-Type: application/json');
  echo '{"status":"1","message":"topic created","topicId":"'.$id.'","userId":"'.$_SESSION['userId'].'"}';
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
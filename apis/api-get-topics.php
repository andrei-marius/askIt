<?php
try{
  session_start();
  if( !$_SESSION ){ sendError(401, 'user is not authenticated', __LINE__ ); }
  
  require_once(__DIR__.'../../private/db.php');

  $q = $db->prepare('SELECT * FROM topics');
  $q->execute();
  $aRows = $q->fetchAll();
  if( $aRows ){
    $aRows = array_map(function($aRow){
        return array(
            'id' => $aRow['0'],
            'userId' => $aRow['1'],
            'title' => $aRow['2'],
            'description' => $aRow['3']
        );
    }, $aRows);
    header('Content-Type: application/json');
    echo '{"status":"1","message":"topics loaded","topics":'.json_encode($aRows).',"userName":"'.$_SESSION['userName'].'"}';
  }else{
    sendError(500, 'data not found', __LINE__);
  }
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
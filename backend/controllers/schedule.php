<?php
date_default_timezone_set('Asia/Tokyo');
require_once('../dbc.php');

$dbh = dbConnect();
$mode = $_SERVER["REQUEST_METHOD"];

if($mode == 'GET'){

  $sql = "SELECT * FROM schedule WHERE grade = :grade";

  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':grade', $_GET['grade']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode($result);
  
}else if($mode == 'POST') {
  
  $request = json_decode(file_get_contents('php://input'));
  $func = $request->func;
  $grade = $request->grade;

  if($func == 'create'){
    $table_json = json_encode($request->schedule_json);
    $sql = "INSERT INTO schedule (grade, table_json) VALUES (:grade, :table_json)";
  }elseif($func == 'update'){
    $table_json = json_encode($request->schedule_json);
    $sql = "UPDATE schedule SET table_json = :table_json WHERE grade = :grade";
  }elseif($func == 'delete'){
    $sql = "DELETE FROM schedule WHERE grade = :grade";
  }

  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':grade', $grade);
  if($func == 'create' || $func == 'update'){
    $stmt->bindValue(':table_json', $table_json);
  }

  $stmt->execute();

  // error_log(print_r($stmt->errorInfo(),true),"3","/Users/mankuki_era/Documents/debug.log");
  // error_log(print_r(strlen($table_json),true),"3","/Users/mankuki_era/Documents/debug.log");

  // ALTER TABLE schedule AUTO_INCREMENT = 1;
}

?>
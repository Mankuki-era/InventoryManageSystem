<?php

date_default_timezone_set('Asia/Tokyo');
require_once('../dbc.php');

$dbh = dbConnect();
$mode = $_SERVER["REQUEST_METHOD"];

if($mode == 'GET'){
  $func = $_GET['func'];

  if($func == 'index'){
    $sql = "SELECT * FROM user WHERE grade = :grade";
  }elseif($func == 'show'){
    $sql = "SELECT * FROM Items WHERE id = :id";
  }
    
  $stmt = $dbh->prepare($sql);
  if($func == 'index'){
    $stmt->bindValue(':grade', $_GET['grade']);
  };
  if($func == 'show') $stmt->bindValue(':id', $_GET['id']);
  $stmt->execute();
  
  if($func == 'index') $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if($func == 'show') $result = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode($result);

}else if($mode == 'POST') {

  $request = json_decode(file_get_contents('php://input'));
  $func = $request->func;
  
  $dbColumn = ['team','number','name'];
  $dbColumnString = '(' . implode(',', $dbColumn) . ',grade' . ')';

  if($func == 'create'){
    $json= json_encode($request->datas); // ObjectをArrayに変換①
    $datas = json_decode($json, true); // ObjectをArrayに変換②
    $xlsxColumn = ['班','学籍番号','学生氏名'];
    $sql = "INSERT INTO user $dbColumnString VALUES";
    $arySql1 = [];
    foreach($datas as $key1 => $val1){
      $array2 = [];
      foreach($dbColumn as $key2 => $val2){
        $array2[] = ":$val2$key1";
      }
      $array1[] = '(' . implode(',', $array2) . ',:grade' . ')';
    }
    $sql .= implode(',', $array1);
    // error_log(print_r($sql,true),"3","/Users/mankuki_era/Documents/debug.log");
  }elseif($func == 'update'){
    $json= json_encode($request->data); // ObjectをArrayに変換①
    $data = json_decode($json, true); // ObjectをArrayに変換②
    $dbColumnVind = array_map(function($column){
      return "$column = :$column";
    }, $dbColumn);
    $dbColumnVindString = implode(',', $dbColumnVind);
    $sql = "UPDATE Items SET $dbColumnVindString, updated_at = :updated_at WHERE id = :id";
  }elseif($func == 'delete'){
    $sql = "DELETE FROM Items WHERE id = :id";
  }elseif($func == 'delete-all'){
    $sql = "DELETE FROM user WHERE grade = :grade";
  }

  $stmt = $dbh->prepare($sql);

  if($func == 'create'){
    foreach($datas as $key1 => $val1){
      foreach($dbColumn as $key2 => $val2){
        $value = $val1[$xlsxColumn[$key2]] ? $val1[$xlsxColumn[$key2]] : null;
        $stmt->bindValue(":$val2$key1", $value);
      }
    }
    $stmt->bindValue(":grade", $request->grade);
  }elseif($func == 'update'){
    foreach($dbColumn as $key => $val){
      $stmt->bindValue(":$val", $data[$val]);
    };
    $stmt->bindValue(":updated_at", date('Y-m-d H:i:s'));
    $stmt->bindValue(":id", $request->id);
  }elseif($func == 'delete'){
    $stmt->bindValue(':id', $request->id);
  }elseif($func == 'delete-all'){
    $stmt->bindValue(':grade', $request->grade);
  }

  $stmt->execute();

  // ALTER TABLE user AUTO_INCREMENT = 1;
}

?>
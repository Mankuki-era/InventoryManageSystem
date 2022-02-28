<?php

date_default_timezone_set('Asia/Tokyo');
require_once('../dbc.php');

$dbh = dbConnect();
$mode = $_SERVER["REQUEST_METHOD"];

if($mode == 'GET'){
  $func = $_GET['func'];

  if($func == 'index'){
    $sql = "SELECT * FROM log WHERE grade = :grade ORDER BY created_at DESC";
  }
    
  $stmt = $dbh->prepare($sql);
  if($func == 'index') $stmt->bindValue(':grade', $_GET['grade']);
  $stmt->execute();
  
  if($func == 'index') $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($result);

}else if($mode == 'POST') {

  $request = json_decode(file_get_contents('php://input'));
  $func = $request->func;
  
  $dbColumn = ['name','url','require_amount','stock_amount','category','favorite'];
  $dbColumnString = '(' . implode(',', $dbColumn) . ')';

  if($func == 'create-type01'){
    $json= json_encode($request->datas); // ObjectをArrayに変換①
    $datas = json_decode($json, true); // ObjectをArrayに変換②
    $xlsxColumn = ['製品名','URL','必要数','在庫数','カテゴリー','お気に入り'];
    $sql = "INSERT INTO Items $dbColumnString VALUES";
    $arySql1 = [];
    foreach($datas as $key1 => $val1){
      $array2 = [];
      foreach($dbColumn as $key2 => $val2){
        $array2[] = ":$val2$key1";
      }
      $array1[] = '(' . implode(',', $array2) . ')';
    }
    $sql .= implode(',', $array1);
  }elseif($func == 'create-type02'){
    $json= json_encode($request->data); // ObjectをArrayに変換①
    $data = json_decode($json, true); // ObjectをArrayに変換②
    $dbColumnVind = array_map(function($column){
      return ":$column";
    }, $dbColumn);
    $dbColumnVindString = '(' . implode(',', $dbColumnVind) . ')';
    $sql = "INSERT INTO Items $dbColumnString VALUES $dbColumnVindString";
  }elseif($func == 'update'){
    $json= json_encode($request->data); // ObjectをArrayに変換①
    $data = json_decode($json, true); // ObjectをArrayに変換②
    $dbColumnVind = array_map(function($column){
      return "$column = :$column";
    }, $dbColumn);
    $dbColumnVindString = implode(',', $dbColumnVind);
    $sql = "UPDATE Items SET $dbColumnVindString, updated_at = :updated_at WHERE id = :id";
  }elseif($func == 'update-favorite'){
    $sql = "UPDATE Items SET favorite = :favorite WHERE id = :id";
  }elseif($func == 'delete'){
    $sql = "DELETE FROM Items WHERE id = :id";
  }elseif($func == 'delete-all'){
    $sql = "TRUNCATE TABLE Items";
  }

  $stmt = $dbh->prepare($sql);

  if($func == 'create-type01'){
    foreach($datas as $key1 => $val1){
      foreach($dbColumn as $key2 => $val2){
        $value = $val1[$xlsxColumn[$key2]];
        if($val2 != 'favorite' && $val1[$xlsxColumn[$key2]] == null) $value = '';
        if($val2 == 'favorite' && $val1[$xlsxColumn[$key2]] == null) $value = '0';
        $stmt->bindValue(":$val2$key1", $value);
      }
    }
  }elseif($func == 'create-type02'){
    foreach($dbColumn as $key => $val){
      $stmt->bindValue(":$val", $data[$val]);
    };
  }elseif($func == 'update'){
    foreach($dbColumn as $key => $val){
      $stmt->bindValue(":$val", $data[$val]);
    };
    $stmt->bindValue(":updated_at", date('Y-m-d H:i:s'));
    $stmt->bindValue(":id", $request->id);
  }elseif($func == 'update-favorite'){
    $stmt->bindValue(":favorite", $request->favorite);
    $stmt->bindValue(":id", $request->id);
  }elseif($func == 'delete'){
    $stmt->bindValue(':id', $request->id);
  }

  $stmt->execute();

  // ALTER TABLE user AUTO_INCREMENT = 1;
}

?>



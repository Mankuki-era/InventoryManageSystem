<?php

function dbConnect(){
  $dsn = 'mysql:host=localhost;dbname=attendance;charset=utf8';
  $user = 'root';
  $pass = 'root';

  try {
    $dbh = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
  }catch(PDOException $error){
    echo '接続失敗'. $error->getMessage();
    exit();
  };

  return $dbh;
}
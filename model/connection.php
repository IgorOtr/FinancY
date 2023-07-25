<?php

$host = 'localhost';
$db_name = 'financy';
$db_user = 'root';
$db_password = '';

try {
    $conn = new PDO('mysql:host='.$host.';dbname='.$db_name, $db_user, $db_password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
  }
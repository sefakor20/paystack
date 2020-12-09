<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $connection = new PDO("mysql:host=$servername;dbname=test_db", $username, $password);
  // set the PDO error mode to exception
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
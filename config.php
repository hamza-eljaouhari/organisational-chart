<?php

// Server=localhost;Database=master;Trusted_Connection=True;

$servername = "localhost";
$username = "username";
$password = "password";
$database = "organizational_chart";

try {
  $conn = new PDO("sqlsrv:host=$servername;dbname=master    ", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

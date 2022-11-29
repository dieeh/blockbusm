<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "blockbusm";
try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd;", $usuario, $clave);
  } catch (PDOException $e) {
    die('Connection Failed: ' . $e->getMessage());
  }
?>
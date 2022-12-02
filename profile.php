<?php
session_start();
include(./db.php)

$user = $_SESSIONI"usuario ];
$sql = "SELECT 1d, usuario, password, FROM  p WHERE usuario='".$user."';

   $resultado =$conexion->query ($sql);

   while($data=$resultado->fetch_assoc()){
      $id = $data['id'];
      $nombre= $data['nombre'];
      $seguidores= $data['seguidores'];
   }
?>
<!DOCTYPE html>
<html lang = "es">
<head>
    <meta charset ="UTF-8">
    <meta http-equiv=" X-UA-Compatible" content="IE=edge">
    <meta name "viewport" content"width=device-width, initial-scale=1,0>
    <title> Mi Perfil</title>
<head>
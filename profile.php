<?php
session_start();
include "conexion.php";

$user = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id=$user";

   $resultado =$conexion->query($sql);

   while($data=$resultado->fetch(PDO::FETCH_ASSOC)){
      $id = $data['id'];
      $nombre= $data['username'];
      //$seguidores= $data['seguidores'];
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php
        require "partials/header.php";
    ?>
</body>
</html>
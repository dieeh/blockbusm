<?php
  session_start();

  require "conexion.php";

  if (isset($_SESSION['adminuser_id'])) {
    $records = $conexion->prepare('SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_id = :id');
    $records->bindParam(':id', $_SESSION['adminuser_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/></head>
    <link rel="stylesheet" href="assets/css/style_sec.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<body>
    <?php require "partials/header2.php"?>
    <section></section>
    <?php if(!empty($user)): ?>
        <a style="color: #fff;">
            <br> Welcome. <?= $user['admin_username']; ?>
            <br> You are Successfully Logged In
            <a href="salir.php">
                Logout
            </a>
        </a>
    <?php else: ?>
        <h1 style="color: #fff;">Access denied. Please <a href="adminlogin.php">Login</a></h1>
    <?php endif; ?>
    
    
</body>
</html>
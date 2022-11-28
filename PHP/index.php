<?php
  session_start();

  require "conexion.php";

  if (isset($_SESSION['user_id'])) {
    $records = $conexion->prepare('SELECT id, username, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://www.dafontfree.net/embed/aXRjLW1hY2hpbmUtc3RkLWJvbGQmZGF0YS80Ni9pLzYwMTUzL01hY2hpbmVTdGQtQm9sZC5vdGY" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php require "partials/header.php"?>
    <section></section>
    <?php if(!empty($user)): ?>
        <br> Welcome. <?= $user['username']; ?>
        <br>You are Successfully Logged In
        <a href="salir.php">
            Logout
        </a>
    <?php else: ?>
        <h1>Please Login or SignUp</h1>
        <a href="login.php">Login</a> or
        <a href="registrar.php">SignUp</a>
    <?php endif; ?>
    
    
</body>
</html>
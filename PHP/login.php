<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        header('Location: /blockbusm/PHP');
    }
    require "conexion.php";

    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $records = $conexion->prepare('SELECT id, username, password FROM users WHERE username = :usuario');
        $records->bindParam(':usuario', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';
        if (count($results) > 0 && password_verify($_POST['clave'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header("Location: /blockbusm/PHP");
          } else {
            $message = 'Sorry, those credentials do not match';
          }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://www.dafontfree.net/embed/aXRjLW1hY2hpbmUtc3RkLWJvbGQmZGF0YS80Ni9pLzYwMTUzL01hY2hpbmVTdGQtQm9sZC5vdGY" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php require "partials/header.php" ?>
    <div class="bg-image"></div>
    <div class="bg-text" align="center">
        <h1>Login</h1>
        <span>First time around? <a href="registrar.php">Sign Up</a></span>
        <?php if (!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="usuario" placeholder="Please enter your username">
            <input type="password" name="clave" placeholder="Please enter your password">
            <input type="submit" value="Enter">
        </form>
    </div>
</body>
</html>
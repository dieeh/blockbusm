<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        header('Location: /blockbusm');
    }
    require "conexion.php";

    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $records = $conexion->prepare('SELECT id, username, password FROM users WHERE username = :usuario');
        $records->bindParam(':usuario', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';
        if ($results == NULL) {
            $message = 'Sorry, that account does not exist';
        } elseif (count($results) > 0 && password_verify($_POST['clave'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header("Location: /blockbusm");
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
    <title>Login | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php" ?>
    <div class="bg-image"></div>
    <div class="bg-text" align="center">
        <h1>Login</h1>
        <?php if (!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="usuario" placeholder="Please enter your username">
            <input type="password" name="clave" placeholder="Please enter your password">
            <input type="submit" value="Enter">
        </form>
        <span>First time around? <a href="registrar.php">Sign Up</a></span>
    </div>
</body>
</html>
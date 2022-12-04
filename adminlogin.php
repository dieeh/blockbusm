<?php
    session_start();

    if (isset($_SESSION['adminuser_id'])) {
        header('Location: /blockbusm/adminpage.php');
    }
    require "conexion.php";

    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $records = $conexion->prepare('SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_username = :usuario');
        $records->bindParam(':usuario', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';
        if (count($results) > 0 && password_verify($_POST['clave'], $results['admin_password'])) {
            $_SESSION['adminuser_id'] = $results['admin_id'];
            header("Location: /blockbusm/adminpage.php");
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
    <title>Admin Login | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style_sec.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header2.php" ?>
    <div class="bg-image"></div>
    <div class="bg-text" align="center">
        <h1>Login</h1>
        <?php if (!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form action="adminlogin.php" method="POST">
            <input type="text" name="usuario" placeholder="Please enter your username">
            <input type="password" name="clave" placeholder="Please enter your password">
            <input type="submit" value="Enter">
        </form>
    </div>
</body>
</html>
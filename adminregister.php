<?php 
    require "conexion.php";
    $message = '';
    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $quer = "INSERT INTO admin (admin_username, admin_password) VALUES (:usuario, :clave)";
        $sttmnt = $conexion->prepare($quer);
        $sttmnt->bindParam(':usuario',$_POST['usuario']);
        $clave = password_hash($_POST['clave'], PASSWORD_BCRYPT);
        $sttmnt->bindParam(':clave',$clave);

        if ($sttmnt->execute()) {
            $message = "Created new user successfully, now you can log in";
        }else {
            $message = "Failed to create a new user, try again later";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>    
    <link rel="stylesheet" href="assets/css/style_sec.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header2.php" ?>
    <div class="bg-image"></div>
    <div class="bg-text" align="center">
        <h1>Sign Up</h1>
        <?php if (!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form action="adminregister.php" method="POST">
            <input type="text" name="usuario" placeholder="Please enter your username">
            <input type="password" name="clave" placeholder="Please enter your password">
            <input type="password" name="confirmar_clave" placeholder="Please confirm your password">
            <input type="submit" value="Enter">
        </form>
        <span>Not new here? <a href="adminlogin.php">Login</a></span>

    </div>
</body>
</html>
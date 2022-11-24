<?php
    require "conexion.php";
    session_start();
    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $records = "SELECT COUNT(*) FROM users WHERE username=:usuario");
        $records->bind_param(":usuario", $_POST['usuario']);
        $consulta = mysqli_query($conexion, $records);
        $array = mysqli_fetch_array($consulta);
        if ($array['contar']>0 && password_verify($_POST['clave'], )) {  //fix all db stuff
            $_SESSION['username'] = $usuario;
            header("location: ../paginaprincipal.php");
        }else {
            echo "Datos incorrectos";
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
</head>
<body>
    <?php require "partials/header.php" ?>
    <h1>Login</h1>
    <span>First time around? <a href="registrar.php">Sign Up</a></span>
    <center>
    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Please enter your username">
        <input type="password" name="clave" placeholder="Please enter your password">
        <input type="submit" value="Enter">
    </form>
    </center>
</body>
</html>
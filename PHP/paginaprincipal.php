<?php
session_start();
$usuario = $_SESSION['username'];
echo "<h1>Bienvenido $usuario</h1>";
echo "<a href='logica/salir.php'>SALIR</a>";
?>


<style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            background-image: url("assets/img/moviewallpaper.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }
    </style>


<?php require "partials/header.php" ?>
    <h1>Login</h1>
    <span>First time around? <a href="registrar.php">Sign Up</a></span>
    <center>
    <?php if (!empty($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Please enter your username">
        <input type="password" name="clave" placeholder="Please enter your password">
        <input type="submit" value="Enter">
    </form>
    </center>
    </div>
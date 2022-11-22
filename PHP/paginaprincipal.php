<?php
session_start();
$usuario = $_SESSION['username'];
echo "<h1>Bienvenido $usuario</h1>";
echo "<a href='logica/salir.php'>SALIR</a>";
?>
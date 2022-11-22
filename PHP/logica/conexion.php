<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "";
$conexion = mysqli_connect($host,$usuario,$clave,$bd);
if ($conexion) {
    echo "Conexión realizada correctamente";
}else {
    echo "Conexión fallida";
}
?>
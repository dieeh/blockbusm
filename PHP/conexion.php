<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "blockbusm";
$conexion = mysqli_connect($host,$usuario,$clave,$bd);
if ($conexion) {
    echo "Conexión realizada correctamente";
}else {
    echo "Conexión fallida";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con sesión</title>
</head>
<body>
    <center>
    <form action="logica/loguear.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario">
        <br><br>
        <input type="password" name="clave" placeholder="Contraseña">
        <br><br>
        <button type="sumbit">ENTRAR</button>
    </form>
    </center>
</body>
</html>
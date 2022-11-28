<?php
    require "conexion.php";
    session_start();
    if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
        $records = $conn->prepare('SELECT username, password FROM users WHERE username = :usuario');
        $records->bindParam(':usuario', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';
        if (count($results) > 0 && password_verify($_POST['clave'], $results['password'])) {
            $_SESSION['username'] = $results['username'];
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
    <title>Login con sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-text">
        <h1>I am John Doe</h1>
        <p>And I'm a Photographer</p>
    </div>
</body>
</html>
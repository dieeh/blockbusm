<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <?php require "partials/header.php" ?>
    <h1>Sign Up</h1>
    <span>Not new here? <a href="login.php">Login</a></span>
    <center>
    <form action="registrar.php">
        <input type="text" name="usuario" placeholder="Please enter your username">
        <br><br>
        <input type="password" name="clave" placeholder="Please enter your password">
        <br><br>
        <input type="password" name="confirmar_clave" placeholder="Please confirm your password">
        <br><br>
        <input type="submit" value="Enter">
    </form>
        
    

</body>
</html>
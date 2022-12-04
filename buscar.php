<?php
    session_start();

    require "conexion.php";

    if (isset($_SESSION['user_id'])) {
        $records = $conexion->prepare('SELECT id, username, password FROM users WHERE id = :id');
        $records->bindParam(':id', $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $user = null;

        if (count($results) > 0) {
            $user = $results;
        }
    }

    if (!empty($_POST['srch'])) {
        $searchuser= $_POST['srch'];
        $quer_user = $conexion->prepare("SELECT * FROM users WHERE username LIKE '%$searchuser%'");
        //$quer_user->bindParam(':searchuser', $_POST['srch']);
        $searchpeli = $_POST['srch'];
        $sentenciaSQL=$conexion->prepare("SELECT * FROM movies_carac WHERE title LIKE '%$searchpeli%'");
        //$sentenciaSQL->bindParam(':searchpeli',$_POST['srch']);
    } else {
        $quer_user = $conexion->prepare("SELECT * FROM users");
        $sentenciaSQL=$conexion->prepare("SELECT * FROM movies_carac");

    }

    $quer_user->execute();
    $result1 = $quer_user->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL->execute();
    $result=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php"?>

    <h1>Movies found:</h1>
    <div class="col-md-3">
    <?php 
    foreach($result as $movies){ ?>
        <div class="card">
            <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies['image'];?>" alt="" height="300">
            <div class="card-body">
                <h4 class="card-title"><?php echo $movies['title'];?></h4>
                <h4 class="card-title"><?php echo $movies['gender'];?></h4>
                <a class="btn" href="ver.php?view=<?php echo $movies['id_movie']; ?>">Ver más</a>
                <a class="btn" href="">Arrendar</a>
            </div>
        </div>
    <?php } ?>
    </div>
    
    <h1>Users found:</h1>
    <div class="col-md-3">
    <?php
    foreach ($result1 as $nombrecito) { ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $nombrecito['username'];?></h4>
                <a href="profile.php?view=<?php echo $nombrecito['id']; ?>" class="btn">Ver perfil</a>
                <a href="buscar.php?follow=<?php echo $nombrecito['id']; ?>" class="btn">Seguir</a>
            </div>
        </div>
    <?php } ?>
    </div>
</body>
</html>
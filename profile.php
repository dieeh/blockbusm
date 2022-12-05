<?php
    session_start();
    include "conexion.php";

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


    $follow = $conexion->prepare('SELECT * FROM followers WHERE follower_id = :user1');
    $follow->bindParam(':user1',$_SESSION['user_id']);
    $follow->execute();
    $res1 = $follow->fetchAll(PDO::FETCH_ASSOC);
    $res = count($res1);

    if (isset($_GET['follow'])) {
        $followeduser = $_GET['follow'];
        $usr = $_SESSION['user_id'];
        $fol = $conexion->prepare("INSERT INTO followers (follower_id, following_id) VALUES ('$usr','$followeduser')");
        $fol->execute();
        $string = "Refresh: 0";
        header($string);
    }

    if (isset($_GET['view'])){
        $viewed_user = $_GET['view'];
        $viewer = $conexion->prepare("SELECT * FROM users WHERE id = $viewed_user");
        $viewer->execute();
        $resultados = $viewer->fetch(PDO::FETCH_ASSOC);
        $viewer2 = $conexion->prepare("SELECT * FROM rented_movies WHERE renter = $viewed_user");
        $viewer2->execute();
        $resultados2 = $viewer2->fetchAll(PDO::FETCH_ASSOC);
        $num = count($resultados2);

        $viewer3 = $conexion->prepare("SELECT * FROM followers WHERE follower_id = $viewed_user");
        $viewer3->execute();
        $resultados2 = $viewer3->fetchAll(PDO::FETCH_ASSOC);
        $seguidos = count($resultados2);
        $viewer4 = $conexion->prepare("SELECT * FROM followers WHERE following_id = $viewed_user");
        $viewer4->execute();
        $resultados5 = $viewer4->fetchAll(PDO::FETCH_ASSOC);
        $seguidores = count($resultados5);
    }   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php" ?>

    <div class="main" style="width: 1130px; max-width: 95%; margin: 0 auto; display: flex; align-items: center; justify-content: space-around; padding: 30px;">
        <img src="assets/img/icon-profile.png" style="height: auto; width: 200px;">
        <div class="about-text" style="width: 550px;">
            <h1 style="font-size: 60px; text-transform: capitalize; margin-bottom: 20px;"><?php echo $resultados['username'];?></h1>
            <h3 style="font-size: 20px; margin-bottom: 25px; letter-spacing: 2px;"><?php echo $resultados['total_rented'];?> movies rented in total · <?php echo $num;?> movies rented now</h3>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;"><?php echo $seguidores;?> followers · following <?php echo $seguidos;?></p>
        </div>
    </div>
</body>
</html>
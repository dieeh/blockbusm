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


    $follow = $conexion->prepare('SELECT * FROM followers WHERE follower_id = :user1 AND following_id = :user2');
    $follow->bindParam(':user1',$_SESSION['user_id']);
    $follow->bindParam(':user2',$_GET['view']);
    $follow->execute();
    $res1 = $follow->fetchAll(PDO::FETCH_ASSOC);
    $res = count($res1);

    $getName = $conexion->prepare("SELECT username FROM users WHERE id  = :user3");
    $getName->bindParam(':user3',$_GET['view']);
    $getName->execute();
    $name = $getName->fetchAll(PDO::FETCH_ASSOC);

    $data_seguidos = $conexion->prepare("SELECT * FROM users WHERE id IN (SELECT following_id FROM followers WHERE follower_id = :user3)");
    $data_seguidos->bindParam(':user3',$_GET['view']);
    $data_seguidos->execute();
    $dataF = $data_seguidos->fetchAll(PDO::FETCH_ASSOC);

    $temp23 = $conexion->prepare("SELECT id_movie_reviewed, score, comment FROM reviews WHERE id_reviewer = :weta");
    $temp23->bindParam(':weta', $_GET['view']);
    $temp23->execute();
    $res23 = $temp23->fetchAll(PDO::FETCH_ASSOC);



    if (isset($_GET['follow'])) {
        $followeduser = $_GET['follow'];
        $usr = $_SESSION['user_id'];
        $fol = $conexion->prepare("INSERT INTO followers (follower_id, following_id) VALUES ('$usr','$followeduser')");
        $fol->execute();
        $string = "Location: profile.php?view=$followeduser";
        header($string);
    }

    if (isset($_GET['unfollow'])) {
        $unfollowuser = $_GET['unfollow'];
        $usr = $_SESSION['user_id'];
        $unf = $conexion->prepare("DELETE FROM followers WHERE follower_id = $usr AND following_id = $unfollowuser");
        $unf->execute();
        $string = "Location: profile.php?view=$unfollowuser";
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
        <img src="assets/img/icon-profile.png" style="height: auto; width: 300px;">
        <div class="about-text" style="width: 550px;">
            <h1 style="font-size: 60px; text-transform: capitalize; margin-bottom: 20px;"><?php echo $resultados['username'];?></h1>
            <h3 style="font-size: 20px; margin-bottom: 25px; letter-spacing: 2px;"><?php echo $resultados['total_rented'];?> movies rented in total · <?php echo $num;?> movies rented now</h3>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;"><?php echo $seguidores;?> followers · following <?php echo $seguidos;?></p>
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['user_id'] != $_GET['view']): ?>
                    <?php if($res > 0): ?>
                        <a class="btn2" href="profile.php?unfollow=<?php echo $resultados['id']; ?>">Unfollow</a>
                    <?php else: ?>
                        <a class="btn" href="profile.php?follow=<?php echo $resultados['id']; ?>">Follow</a>
                    <?php endif; ?>
                    <a class="btn" href="wishlist.php?view=<?php echo $resultados['id']; ?>">View wishlist</a>
                <?php else: ?>
                    <a class="btn" href="editacc.php?edit=<?php echo $_SESSION['user_id']; ?>">Edit account</a>
                    <a class="btn" href="wishlist.php?view=<?php echo $_SESSION['user_id']; ?>">View wishlist</a>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn" href="login.php">Login to access to all functions</a>
            <?php endif; ?>
        </div>
    </div>
    <h1>Users followed by <?php echo $name[0]['username'] ?>:</h1>
    <div class="col-md-3">
    <?php
    foreach ($dataF as $nombrecito) { ?>
        <div class="card">
            <div class="card-body">
                <img class="card-img-top" src="assets/img/icon-profile.png" alt="" height="200">
                <h4 class="card-title"><?php echo $nombrecito['username'];?></h4>
                <a href="profile.php?view=<?php echo $nombrecito['id']; ?>" class="btn">See profile</a>
            </div>
        </div>
    <?php } ?>
    </div>
    <h1>Reviews given by <?php echo $name[0]['username'] ?>:</h1>
    <div class="col-md-3">
    <?php
        foreach ($res23 as $datas) { ?>
            <?php
                $temp2 = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie = :weta");
                $temp2->bindParam(':weta', $datas['id_movie_reviewed']);
                $temp2->execute();
                $result2 = $temp2->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="card">
                <div class="card-body">
                    <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">You gave the movie <?php echo $result2['title'] ?> a score of <?php echo $datas['score']; ?></p>
                    <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">And added the following comment: <?php echo $datas['comment']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
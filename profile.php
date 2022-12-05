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
        $viewed_user = $_GET['view']
        $viewer = $conexion->prepare("SELECT * FROM users WHERE id = $viewed_user");
        $viewer->execute();
        $resultados = $viewer->fetchAll(PDO::FETCH_ASSOC);
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
    <div class = "inf">
        <div class = "inf"><b><?php echo $totalS; ?></b> seguidores </div>
        <div class = "inf"><b><?php echo $totalC; ?></b> seguidos </div>
    </div>
</body>
</html>
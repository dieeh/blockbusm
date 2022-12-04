<?php
    session_start();

    require "conexion.php";

    $peli_id = $_GET['view'];
    

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

    $wished = $conexion->prepare('SELECT * FROM wishlist WHERE id_movie = :peli AND wisher = :user');
    $wished->bindParam(':peli',$peli_id);
    $wished->bindParam(':user',$_SESSION['user_id']);
    $wished->execute();
    $res1 = $wished->fetchAll(PDO::FETCH_ASSOC);
    $res = count($res1);

    $data = $conexion->prepare('SELECT * FROM movies_carac WHERE id_movie = :id');
    $data->bindParam(':id', $peli_id);
    $data->execute();
    $row = $data->fetch(PDO::FETCH_ASSOC);

    if (isset($_GET['wish'])) {
        $id_mov = $_GET['wish'];
        $usr = $_SESSION['user_id'];
        $ins = $conexion->prepare("INSERT INTO wishlist (id_movie, wisher) VALUES ('$id_mov','$usr')");
        $ins->execute();
        $string = "Location: ver.php?view=$id_mov";
        header($string);
    }

    if (isset($_GET['delete'])) {
        $peli_del = $_GET['delete'];
        $usr = $_SESSION['user_id'];
        $del = $conexion->prepare("DELETE FROM wishlist WHERE id_movie = $peli_del AND wisher = $usr");
        $del->execute();
        $string = "Location: ver.php?view=$peli_del";
        header($string);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php"?>´
    
    <div class="main" style="width: 1130px; max-width: 95%; margin: 0 auto; display: flex; align-items: center; justify-content: space-around;">
        <img src="assets/img/posters/uploaded/<?php echo $row['image'];?>" style="height: auto; width: 400px;">
        <div class="about-text" style="width: 550px;">
            <h1 style="font-size: 60px; text-transform: capitalize; margin-bottom: 20px;"><?php echo $row['title'];?></h1>
            <h3 style="font-size: 20px; text-transform: capitalize; margin-bottom: 25px; letter-spacing: 2px;"><?php echo $row['gender'];?> · <?php echo $row['public'];?> · <?php echo $row['lenght'];?>m</h3>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;">Starring: <?php echo $row['cast'];?></p>
            <p style="font-size: 15px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;"><?php echo $row['description'];?></p>
            <?php if($res > 0): ?>
                <a class="btn2" href="ver.php?delete=<?php echo $row['id_movie']; ?>">Remove from wishlist</a>
            <?php else: ?>
                <a class="btn" href="ver.php?wish=<?php echo $row['id_movie']; ?>">Add to wishlist</a>
            <?php endif; ?>
            <a class="btn" href="ver.php?view=<?php echo $row['id_movie']; ?>">Rent</a>
            <a class="btn2" href="ver.php?return=<?php echo $row['id_movie']; ?>">Return</a>
        </div>
    </div>

</body>
</html>
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
    <?php 
    foreach($result as $movies){ ?>
        <div class="col-md-3">
            <div class="card">
                <img class="card-img-top" src="/assets/img/posters/uploaded/<?php echo $movies['image'];?>" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $movies['title'];?></h4>
                    <h4 class="card-title"><?php echo $movies['gender'];?></h4>
                    <a name="" id="" class="btn" href="" role="button">Ver más</a>
                    <a name="" id="" class="btn" href="" role="button">arrendar</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <h1>Users found:</h1>
    <?php
    foreach ($result1 as $nombrecito) { ?>
       <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $nombrecito['title'];?></h4>
                    <a name="" id="" class="btn" href="" role="button">Ver perfil</a>
                    <a name="" id="" class="btn" href="" role="button">Seguir</a>
                </div>
            </div>
       </div>
    <?php } ?>
</body>
</html>
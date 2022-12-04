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

    $last = $conexion->query("SELECT * FROM movies_carac ORDER BY id_movie DESC LIMIT 5");
    $result = $last->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php"?>
    
    <div style:"position: absolute; vertical-alignment: middle;">
        <?php if(!empty($user)): ?>
            <h1>Latest movies added:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result as $movies){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies['id_movie']; ?>">Ver más</a>
                            <a name="" id="" class="btn" href="" role="button">Arrendar</a>
                        </div>
                    </div>
            <?php } ?>
            </div>
                    
        <?php else: ?>
            <section></section>
            <div style="transform: translateY(200px); font-size: 30px;">
                <h1 style="color: #000;">Please Login or Sign Up</h1>
                <a href="login.php">Login</a> or
                <a href="registrar.php">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
    
    
    

</body>
</html>
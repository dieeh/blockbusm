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

    if (isset($_GET['view'])) {
        $wish_data = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie IN (SELECT id_movie FROM wishlist WHERE wisher = :user)");
        $wish_data->bindParam(':user', $_GET['view']);
        $wish_data->execute();
        $result = $wish_data->fetchAll(PDO::FETCH_ASSOC);
    }

    $getName = $conexion->prepare("SELECT username FROM users WHERE id  = :user2");
    $getName->bindParam(':user2',$_GET['view']);
    $getName->execute();
    $name = $getName->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php" ?>
    <div style="padding: 35px;">
        <h1>Wishlist of <?php echo $name[0]['username'] ?>:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result as $movies){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>
        <a class="btn2" href="profile.php?view=<?php echo $_GET['view']; ?>">Go back to profile</a>
    </div>
</body>
</html>
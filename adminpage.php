<?php
    session_start();

    require "conexion.php";

    if (isset($_SESSION['adminuser_id'])) {
        $records = $conexion->prepare('SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_id = :id');
        $records->bindParam(':id', $_SESSION['adminuser_id']);
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
    <title>Main Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/></head>
    <link rel="stylesheet" href="assets/css/admin_sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<body>
    <?php require "partials/header2.php"?>
    <?php if(empty($user)): ?>
        <h1 style="color: #000;">Access denied. Please <a href="adminlogin.php">Login</a></h1>
    <?php else: ?>
        <div class="container">
            <div class="admin-movie-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Add a new movie</h3>
                    <input type="text" placeholder="Enter movie title" name="movie_title" class="box">
                    <input type="text" placeholder="Enter movie gender" name="movie_gender" class="box">
                    <input type="text" placeholder="Enter movie public" name="movie_public" class="box">
                    <input type="number" placeholder="Enter movie lenght" name="movie_lenght" class="box">
                    <input type="text" placeholder="Enter movie cast" name="movie_cast" class="box">
                    <input type="text" placeholder="Enter movie description" name="movie_description" class="box">
                    <input type="file" accept="image/png, image/jpg, image/jpeg" placeholder="Upload movie poster image" name="movie_image" class="box">
                    <input type="submit" value="Add movie" name="add_movie" class="btn">
                </form>
            </div>
        </div>
    <?php endif; ?>
    
    
</body>
</html>
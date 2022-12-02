<?php
    session_start();

    require "conexion.php";

    $id = $_GET['edit'];

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

    if (isset($_POST['update_movie'])) {
        $movie_title  = $_POST['movie_title'];
        $movie_gender = $_POST['movie_gender'];
        $movie_public = $_POST['movie_public'];
        $movie_lenght = $_POST['movie_lenght'];
        $movie_cast = $_POST['movie_cast'];
        $movie_description = $_POST['movie_description'];
        $movie_image = $_FILES['movie_image']['name'];
        $movie_image_tmp_name = $_FILES['movie_image']['tmp_name'];
        $movie_image_folder = 'assets/img/posters/uploaded'.$movie_image;

        if (empty($movie_title) || empty($movie_gender) || empty($movie_public) || empty($movie_lenght) || empty($movie_cast) || empty($movie_description) || empty($movie_image)) {
            $message[]= 'Please fill all fields';
        } else {
            $update = $conexion->query("UPDATE movies_carac SET title = '$movie_title', gender = '$movie_gender', public = '$movie_public', lenght = '$movie_lenght', cast = '$movie_cast', description = '$movie_description', image = '$movie_image' WHERE id_movie = $id");
            $res_upd = $update->execute();
            if ($res_upd) {
                move_uploaded_file($movie_image_tmp_name, $movie_image_folder);
                $message[] = 'Movie updated successfully';
            } else {
                $message[] = "Couldn't update the movie";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/admin_sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php 
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<span class="message">'.$message.'</span>';
            }
        }    
    ?>

    <div class="container">
        <div class="admin-movie-form-container centered">
            <?php
                $select = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie = $id");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Edit a movie</h3>
                <input type="text" placeholder="Enter movie title" value="<?php $row['title'] ?>" name="movie_title" class="box">
                <input type="text" placeholder="Enter movie gender" value="<?php $row['gender'] ?>" name="movie_gender" class="box">
                <input type="text" placeholder="Enter movie public" value="<?php $row['public'] ?>" name="movie_public" class="box">
                <input type="number" min="0" placeholder="Enter movie lenght" value="<?php $row['lenght'] ?>" name="movie_lenght" class="box">
                <input type="text" placeholder="Enter movie cast" value="<?php $row['cast'] ?>" name="movie_cast" class="box">
                <input type="text" placeholder="Enter movie description" value="<?php $row['description'] ?>" name="movie_description" class="box">
                <input type="file" accept="image/png, image/jpg, image/jpeg" placeholder="Upload movie poster image" name="movie_image" class="box">
                <input type="submit" value="Update movie" name="update_movie" class="btn">
                <a href="adminpage.php" class="btn">Go Back</a>
            </form>

            <?php  }; ?>
        </div>
    </div>
</body>
</html>
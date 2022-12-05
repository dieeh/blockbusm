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

    if (isset($_POST['add_details'])) {
        $movie_price  = $_POST['movie_price'];
        $movie_a_units = $_POST['movie_a_units'];
        $movie_t_units = $_POST['movie_t_units'];
        $movie_score = $_POST['movie_score'];
        $movie_u_score = $_POST['movie_u_score'];
        
        if (empty($movie_price) || empty($movie_a_units) || empty($movie_t_units) || empty($movie_score) || empty($movie_u_score)) {
            $message[]= 'Please fill all fields';
        } else {
            $update = $conexion->prepare("INSERT INTO movies_data (id_movie, price, available_units, total_units, site_score, usmtomatoes_score) VALUES ('$id','$movie_price','$movie_a_units','$movie_t_units','$movie_score','$movie_u_score')");
            $res_upd = $update->execute();
            if ($res_upd) {
                $message[] = 'Movie data added successfully';
            } else {
                $message[] = "Couldn't add the movie data";
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
    <title>Edit | BlockbUSM</title>
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
    <h1>Please only fill one of the forms at a time</h1>
    <div class="container" style="display: flex; flex-direction: row; justify-content: space-around; flex-flow: wrap; align-items: center;">

        <div class="admin-movie-form-container">
                <form action="<?php "adminpage.php" ?>" method="POST" enctype="multipart/form-data">
                    <h3>Add details to movie</h3>
                    <input type="number" min="0" placeholder="Enter movie price" name="movie_price" class="box">
                    <input type="number" min="0" placeholder="Enter available units" name="movie_a_units" class="box">
                    <input type="number" placeholder="Enter total units" name="movie_t_units" class="box">
                    <input type="number" min="0" placeholder="Enter site score" name="movie_score" class="box">
                    <input type="number" min="0" placeholder="Enter movie cast" name="movie_u_score" class="box">
                    <input type="submit" value="Add details" name="add_details" class="btn">
                </form>
        </div>
        
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
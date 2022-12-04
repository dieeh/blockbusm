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

    if (isset($_POST['add_movie'])) {
        $movie_title  = $_POST['movie_title'];
        $movie_gender = $_POST['movie_gender'];
        $movie_public = $_POST['movie_public'];
        $movie_lenght = $_POST['movie_lenght'];
        $movie_cast = $_POST['movie_cast'];
        $movie_description = $_POST['movie_description'];
        $movie_image = $_FILES['movie_image']['name'];
        $movie_image_tmp_name = $_FILES['movie_image']['tmp_name'];
        $movie_image_folder = 'assets/img/posters/uploaded/'.$movie_image;

        if (empty($movie_title) || empty($movie_gender) || empty($movie_public) || empty($movie_lenght) || empty($movie_cast) || empty($movie_description) || empty($movie_image)) {
            $message[]= 'Please fill all fields';
        } else {
            $insert = $conexion->prepare("INSERT INTO movies_carac (title, gender, public, lenght, cast, description, image) VALUES ('$movie_title','$movie_gender','$movie_public','$movie_lenght','$movie_cast','$movie_description','$movie_image')");
            $res_ins = $insert->execute();
            if ($res_ins) {
                move_uploaded_file($movie_image_tmp_name, $movie_image_folder);
                $message[] = 'New movie added successfully';
            } else {
                $message[] = "Couldn't add the movie";
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $del = $conexion->prepare("DELETE FROM movies_carac WHERE id_movie = $id");
        $del->execute();
        header('location: adminpage.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/admin_sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header2.php"?>
    <?php if(empty($user)): ?>
        <h1 style="color: #000;">Access denied. Please <a href="adminlogin.php">Login</a></h1>
    <?php else: ?>
        <?php 
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<span class="message">'.$message.'</span>';
                }
            }    
        ?>
        <div class="container">
            <div class="admin-movie-form-container">
                <form action="<?php "adminpage.php" ?>" method="POST" enctype="multipart/form-data">
                    <h3>Add a new movie</h3>
                    <input type="text" placeholder="Enter movie title" name="movie_title" class="box">
                    <input type="text" placeholder="Enter movie gender" name="movie_gender" class="box">
                    <input type="text" placeholder="Enter movie public" name="movie_public" class="box">
                    <input type="number" min="0" placeholder="Enter movie lenght" name="movie_lenght" class="box">
                    <input type="text" placeholder="Enter movie cast" name="movie_cast" class="box">
                    <input type="text" placeholder="Enter movie description" name="movie_description" class="box">
                    <input type="file" accept="image/png, image/jpg, image/jpeg" placeholder="Upload movie poster image" name="movie_image" class="box">
                    <input type="submit" value="Add movie" name="add_movie" class="btn">
                </form>
            </div>
            <?php 
                $select = $conexion->prepare("SELECT * FROM movies_carac");
                $select->execute();

            ?>

            <div class="movie-display">
                <table class="movie-display-table">
                    <thead>
                        <tr>
                            <td>Movie Poster</td>
                            <td>Movie Title</td>
                            <td>Movie Gender</td>
                            <td>Movie Public</td>
                            <td>Movie Lenght</td>
                            <td>Movie Cast</td>
                            <td>Movie Description</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <?php
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><img src="assets/img/posters/uploaded/<?php echo $row['image']; ?>" height="100"></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['public']; ?></td>
                        <td><?php echo $row['lenght']; ?></td>
                        <td><?php echo $row['cast']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <a href="adminedit.php?edit=<?php echo $row['id_movie']; ?>" class="btn"> <i class="fas fa-edit"></i>Edit</a>
                            <a href="adminpage.php?delete=<?php echo $row['id_movie']; ?>" class="btn"> <i class="fas fa-trash"></i>Delete</a>
                        </td>
                    </tr>
                    <?php  }; ?>
                </table>
            </div>
        </div>
    <?php endif; ?>
    
    
</body>
</html>
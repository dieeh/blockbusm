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

    $rented = $conexion->prepare('SELECT * FROM rented_movies WHERE id_movie = :peli AND renter = :user');
    $rented->bindParam(':peli',$peli_id);
    $rented->bindParam(':user',$_SESSION['user_id']);
    $rented->execute();
    $res2 = $rented->fetchAll(PDO::FETCH_ASSOC);
    $res3 = count($res2);

    $data = $conexion->prepare('SELECT * FROM movies_carac WHERE id_movie = :id');
    $data->bindParam(':id', $peli_id);
    $data->execute();
    $row = $data->fetch(PDO::FETCH_ASSOC);

    $rent4 = $conexion->prepare("SELECT * FROM movies_data WHERE id_movie = :id");
    $rent4->bindParam(':id', $peli_id);
    $rent4->execute();
    $precio = $rent4->fetch(PDO::FETCH_ASSOC);
    $precio2 = $precio['price'];

    $usr23 = $_SESSION['user_id'];
    $temp23 = $conexion->prepare("SELECT score, comment FROM reviews WHERE id_reviewer = :weta AND id_movie_reviewed = :peli");
    $temp23->bindParam(':weta', $usr23);
    $temp23->bindParam(':peli', $peli_id);
    $temp23->execute();
    $res23 = $temp23->fetch(PDO::FETCH_ASSOC);

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

    if (isset($_GET['delete_rev'])) {
        $peli_del = $_GET['delete'];
        $usr = $_SESSION['user_id'];
        $del = $conexion->prepare("DELETE FROM review WHERE id_movie_reviewed = $peli_del AND id_reviewed = $usr");
        $del->execute();
        $string = "Location: ver.php?view=$peli_del";
        header($string);
    }

    if (isset($_GET['rent'])) {
        $id_rent = $_GET['rent'];
        $usr = $_SESSION['user_id'];
        $rent = $conexion->prepare("INSERT INTO rented_movies (id_movie, renter) VALUES ('$id_rent','$usr')");
        $rent->execute();
        $rent2 = $conexion->query("UPDATE users SET total_rented = total_rented + 1 WHERE id = $usr");
        $rent3 = $conexion->query("UPDATE movies_data SET times_rented = times_rented + 1 WHERE id_movie = $id_rent");
        $rent3 = $conexion->query("UPDATE movies_data SET available_units = available_units - 1 WHERE id_movie = $id_rent");
        $rent4 = $conexion->query("SELECT price FROM movies_data WHERE id_movie = $id_rent");
        $precio = $rent4->fetch(PDO::FETCH_ASSOC);
        $precio2 = $precio['price'];
        $rent5 = $conexion->query("UPDATE users SET balance = balance - $precio2 WHERE id = $usr");
        $string = "Location: ver.php?view=$id_rent";
        header($string);
    }

    if (isset($_GET['return'])) {
        $peli_ret = $_GET['return'];
        $usr = $_SESSION['user_id'];
        $ret = $conexion->prepare("DELETE FROM rented_movies WHERE id_movie = $peli_ret AND renter = $usr");
        $ret->execute();
        $rent3 = $conexion->prepare("UPDATE movies_data SET available_units = available_units + 1 WHERE id_movie = $peli_ret");
        $rent3->execute();
        $string = "Location: ver.php?view=$peli_ret";
        header($string);
    }

    if(isset($_POST['add_comment'])) {
        if (!isset($_POST['score'])) {
            $message = 'The score is mandatory';
        } else {
            $peli_ret = $_GET['view'];
            $usr = $_SESSION['user_id'];
            $temp = $conexion->query("SELECT * FROM reviews WHERE id_reviewer=$usr AND id_movie_reviewed = $peli_ret");
            $res = $temp->fetch(PDO::FETCH_ASSOC);
            if ($res == null) {
                $query = $conexion->prepare("INSERT INTO reviews (id_reviewer,id_movie_reviewed,score,comment) VALUES (:id,:id_movie,:score,:reviews)");
                $query->bindParam(':reviews', $_POST['comment']);
                $query->bindParam(':score', $_POST['score']);
                $query->bindParam(':id', $_SESSION['user_id']);
                $query->bindParam(':id_movie', $peli_id);
                $query->execute();
                $string = "Location: ver.php?view=$peli_id";
                header($string);
            } elseif (count($res)>0) {
                $query = $conexion->prepare("UPDATE reviews SET score = :score, comment = :reviews  WHERE id_reviewer = :id AND id_movie_reviewed = :id_movie");
                $query->bindParam(':reviews', $_POST['comment']);
                $query->bindParam(':score', $_POST['score']);
                $query->bindParam(':id', $_SESSION['user_id']);
                $query->bindParam(':id_movie', $peli_id);
                $query->execute();
                $string = "Location: ver.php?view=$peli_id";
                header($string);
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
    <title><?php echo $row['title'];?> | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php"?>
    
    <div class="main" style="width: 1200px; max-width: 95%; margin: 0 auto; display: flex; align-items: center; justify-content: space-around; padding: 30px;">
        <img src="assets/img/posters/uploaded/<?php echo $row['image'];?>" style="height: auto; width: 400px;">
        <div class="about-text" style="width: 850px; padding: 25px;">
            <h1 style="font-size: 50px; text-transform: capitalize; margin-bottom: 20px;"><?php echo $row['title'];?></h1>
            <h3 style="font-size: 30px; text-transform: capitalize; margin-bottom: 25px; letter-spacing: 2px;"><?php echo $row['gender'];?> ?? <?php echo $row['public'];?> ?? <?php echo $row['lenght'];?>m</h3>
            <p style="font-size: 22px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;">Starring: <?php echo $row['cast'];?></p>
            <p style="font-size: 20px; line-height: 30px; margin-bottom: 10px; letter-spacing: 1px;"><?php echo $row['description'];?></p>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">This movie has been rented a total of <?php echo $precio['times_rented'];?> time(s)</p>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">There is <?php echo $precio['available_units'];?> of <?php echo $precio['total_units'];?> copies remaining.</p>
            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">This movie has a rating on USMTomatoes of <?php echo $precio['usmtomatoes_score'];?> and a site score of <?php echo $precio['site_score'];?></p>

            <?php if(isset($_SESSION['user_id'])): ?>    
                <?php if($res > 0): ?>
                    <a class="btn2" href="ver.php?delete=<?php echo $row['id_movie']; ?>">Remove from wishlist</a>
                <?php else: ?>
                    <a class="btn" href="ver.php?wish=<?php echo $row['id_movie']; ?>">Add to wishlist</a>
                <?php endif; ?>

                <?php if($res3 > 0): ?>
                    <a class="btn2" href="ver.php?return=<?php echo $row['id_movie']; ?>">Return</a>
                <?php else: ?>
                    <a class="btn" href="ver.php?rent=<?php echo $row['id_movie']; ?>">Rent for $<?php echo $precio2 ?></a>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn" href="login.php">Login to access to all functions</a>
            <?php endif; ?>
        </div>
    </div>
    <?php if(isset($_SESSION['user_id'])): ?>
        <?php if($res3 > 0): ?>
            <div style="width: 750px; max-width: 95%; margin: 0 auto; display: block; padding: 25px; background-color: rgba(200, 200, 200, 0.5); border-radius: 25px;">
                <h3>Want to give us your opinion on this movie?</h3> 
                <?php if (!empty($message)): ?>
                    <p><?= $message ?></p>
                <?php endif; ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >
                   <center>
                       <p>
                           <textarea name="comment" cols="80" rows="5" id="textarea" placeholder="Add a review for this movie"></textarea>
                       </p>
                       <input type="text" placeholder="Enter a score for this movie" name="score" class="box">
                       <input type="submit" value="Comentar" name="add_comment" class="btn">
                   </center>
                </form>
            <?php else: ?>
            <?php endif; ?>
            <?php if ($res23 != NULL) :?>
                <h3>Your review of this movie:</h3> 
                <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">You gave this movie a score of <?php echo $res23['score']; ?></p>
                <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">And added the following comment: <?php echo $res23['comment']; ?></p>
                <a class="btn2" href="ver.php?delete_rev=<?php echo $row['id_movie']; ?>">Delete review</a>
            </div>
            <?php else: ?>
            <?php endif; ?>
        <?php else: ?>
        <?php endif; ?>


</body>
</html>
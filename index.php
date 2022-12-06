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

    $top5best = $conexion->query("SELECT movies_carac.* FROM movies_carac LEFT JOIN movies_data ON movies_carac.id_movie = movies_data.id_movie ORDER BY movies_data.usmtomatoes_score DESC LIMIT 5");
    $result1 = $top5best->fetchAll(PDO::FETCH_ASSOC);

    $limited = $conexion->query("SELECT * FROM movies_carac WHERE id_movie IN (SELECT id_movie FROM movies_data WHERE available_units < 3 )");
    $result2 = $limited->fetchAll(PDO::FETCH_ASSOC);

    $top5worst = $conexion->query("SELECT movies_carac.* FROM movies_carac LEFT JOIN movies_data ON movies_carac.id_movie = movies_data.id_movie ORDER BY movies_data.usmtomatoes_score ASC LIMIT 5");
    $result3 = $top5worst->fetchAll(PDO::FETCH_ASSOC);

    $topsellerPG = $conexion->query("SELECT movies_carac.* FROM movies_carac LEFT JOIN movies_data ON movies_carac.id_movie = movies_data.id_movie WHERE movies_carac.public = 'PG' ORDER BY movies_data.times_rented DESC LIMIT 5");
    $result4 = $topsellerPG->fetchAll(PDO::FETCH_ASSOC);

    $topsellerR = $conexion->query("SELECT movies_carac.* FROM movies_carac LEFT JOIN movies_data ON movies_carac.id_movie = movies_data.id_movie WHERE movies_carac.public = 'R' ORDER BY movies_data.times_rented DESC LIMIT 5");
    $result5 = $topsellerR->fetchAll(PDO::FETCH_ASSOC);

    $topsellerE = $conexion->query("SELECT movies_carac.* FROM movies_carac LEFT JOIN movies_data ON movies_carac.id_movie = movies_data.id_movie WHERE movies_carac.public = 'E' ORDER BY movies_data.times_rented DESC LIMIT 5");
    $result6 = $topsellerE->fetchAll(PDO::FETCH_ASSOC);

    $toprated = $conexion->query("SELECT * FROM movies_carac WHERE id_movie IN (SELECT id_movie_reviewed FROM reviews GROUP BY id_movie_reviewed ORDER BY COUNT(id_movie_reviewed) DESC)");
    $result7 = $toprated->fetchAll(PDO::FETCH_ASSOC);

    $quantRating = $conexion->query("SELECT id_movie_reviewed,COUNT(id_movie_reviewed) FROM reviews GROUP BY id_movie_reviewed ORDER BY COUNT(id_movie_reviewed) DESC");
    $result8 = $quantRating->fetchAll(PDO::FETCH_ASSOC);

    $temp23 = $conexion->prepare("SELECT id_reviewer, id_movie_reviewed, score, comment FROM reviews WHERE id_reviewer IN (SELECT following_id FROM followers WHERE follower_id = :weta)");
    $temp23->bindParam(':weta', $_SESSION['user_id']);
    $temp23->execute();
    $res23 = $temp23->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php"?>
    
    <div style:"position: absolute; vertical-alignment: middle;">
        <?php if(!empty($user)): ?>
            <h1>Latest movies added to BlockbUSM:</h1>
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

            <h1>Reviews made by people you follow:</h1>
            <div class="col-md-3">
            <?php
                foreach ($res23 as $datas) { ?>
                    <?php
                        $temp2 = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie = :weta");
                        $temp2->bindParam(':weta', $datas['id_movie_reviewed']);
                        $temp2->execute();
                        $result_inner = $temp2->fetch(PDO::FETCH_ASSOC);

                        $temp45 = $conexion->prepare("SELECT username FROM users WHERE id= :alo");
                        $temp45->bindParam(':alo', $datas['id_reviewer']);
                        $temp45->execute();
                        $result_inner2 = $temp45->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;"><?php echo $result_inner2['username']?> gave the movie <?php echo $result_inner['title'] ?> a score of <?php echo $datas['score']; ?></p>
                            <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">And added the following comment: <?php echo $datas['comment']; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <h1>Limited stock:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result2 as $movies2){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies2['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies2['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies2['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies2['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 Best Movies by USMTomatoes:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result1 as $movies3){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies3['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies3['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies3['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies3['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 Worst Movies by USMTomatoes:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result3 as $movies4){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies4['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies4['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies4['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies4['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 BestSeller PG rated movies:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result4 as $movies5){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies5['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies5['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies5['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies5['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 BestSeller R rated movies:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result5 as $movies6){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies6['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies6['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies6['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies6['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 BestSeller E rated movies:</h1>
            <div class="col-md-3">
            <?php 
            foreach($result6 as $movies7){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies7['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies7['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies7['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies7['id_movie']; ?>">See more</a>
                        </div>
                    </div>
            <?php } ?>
            </div>

            <h1>Top 5 reviewed movies:</h1>
            <div class="col-md-3">
            <?php 
                foreach($result7 as $movies8){ ?>
                    <div class="card">
                        <img class="card-img-top" src="assets/img/posters/uploaded/<?php echo $movies8['image'];?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $movies8['title'];?></h4>
                            <h4 class="card-title"><?php echo $movies8['gender'];?></h4>
                            <a class="btn" href="ver.php?view=<?php echo $movies8['id_movie']; ?>">See more</a>
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
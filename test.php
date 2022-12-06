<?php
    require "partials/header.php";
    require "conexion.php";

    $quer_user = $conexion->prepare("SELECT * FROM users WHERE username LIKE %$search%");
    $quer_user->execute();
    $result1 = $quer_user->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL=$conexion->prepare("SELECT * FROM movies_carac WHERE id LIKE %$search%");
    $sentenciaSQL->execute();
    $result=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


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


<?php
        foreach ($res23 as $datas) { ?>
            
            <?php
                print_r($datas);
                $temp2 = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie = :weta");
                $temp2->bindParam(':weta', $datas['id_movie_reviewed']);
                $temp2->execute();
                $result2 = $temp2->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="card">
                <div class="card-body">
                    <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">You gave the movie <?php echo $result2['title'] ?> a score of <?php echo $datas['score']; ?></p>
                    <p style="font-size: 18px; line-height: 30px; margin-bottom: 10px;">And added the following comment: <?php echo $datas['comment']; ?></p>
                </div>
            </div>
        <?php } ?>

$temp2 = $conexion->prepare("SELECT * FROM movies_carac WHERE id_movie = :weta");
                $temp2->bindParam(':weta', $datas['id_movie_reviewed']);
                $temp2->execute();
                $result2 = $temp2->fetch(PDO::FETCH_ASSOC);



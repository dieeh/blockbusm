<?php
    session_start();
    require "conexion.php";
    include "funciones.php";

    if(!isset($_SESSION['user_id'])) {
        header("Location: ver.php");
    }

    if(isset($_POST['comentar'])) {
        $query = $conexion->query("INSERT INTO reviews (comment,id_reviewer) value (':reviews',':id'");
        $query->bindParam(':reviews', $_POST['comentario']);
        $query->bindParam(':id', $_SESSION['user_id']);
        if($query) { header("Location: index.php"); }
    }

    ini_set('error_reporting',0);


?>
<!doctype html>
<html lang="es-ES">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>Reseñas</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>    
</head>
<body>
    <div id="L">
        <form action="comentarios.php" method="POST" >
            <center>
                <p>
                    <textarea name="comentario" cols="80" rows="5" id="textarea" placeholder="Add a review for this movie"></textarea>
                </p>
                <input type="number" min="0" placeholder="Enter a score for this movie" name="movie_score" class="box">
                <input type="submit" value="Comentar" class="btn">
            </center>
        </form>
    </div>
</body>
</html>
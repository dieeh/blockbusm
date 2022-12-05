<?php
    session_start();
    include "conexion.php";
    include "funciones.php";

    if(!isset($_SESSION['user_id'])) {
        header("Location: ver.php");
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
        <form name="form1" method="post" action="">
            <label for="textarea"></label>
            <center>
                <p>
                    <textarea name="comentario" cols="80" rows="5" id="textarea"><?php if(isset($_GET['user'])) { ?>@<?php echo $_GET['user']; ?><?php } ?> </textarea>
                </p>
                <p>
                    <input type="submit" <?php if (isset($_GET['id'])) { ?>name="reply"<?php } else { ?>name="comentar"<?php } ?>value="Comentar">
                </p>
            </center>
        </form>
        <?php
            if(isset($_POST['comentar'])) {
                $query = mysql_query("INSERT INTO reviews (comment,id_reviewer) value ('".$_POST['reviews']."','".$_SESSION['user_id']."'");	
                if($query) { header("Location: index.php"); }
            }
        ?>
        <?php
            if(isset($_POST['reply'])) {
                $query = mysql_query("INSERT INTO reviews (comment,usuario) value ('".$_POST['reviews']."','".$_SESSION['user_id']."',NOW(),'".$_GET['id']."')");	
                if($query) { header("Location: index.php"); }
            }
        ?>
        <br>
        <div id="container">
            <ul id="comments">
                
                    <div class="cmmnt-content">
                        <header>
                            <a href="#" class="userlink"><?php echo $user['usuario']; ?></a> - <span class="pubdate"><?php echo $row['fecha']; ?></span>
                        </header>
                        <p>
                            <?php echo $row['comentario']; ?>
                        </p>
                        <span>
                            <a href="index.php?user=<?php echo $user['usuario']; ?>&id=<?php echo $row['id']; ?>">
                            Responder
                            </a>
                        </span>
                    </div>
                    <?php
                        $contar = mysql_num_rows(mysql_query("SELECT * FROM reviews WHERE reply = '".$row['id']."'"));
                        if($contar != '0') {
                            $reply = mysql_query("SELECT * FROM reviews WHERE reply = '".$row['id']."' ORDER BY id DESC");
                            while($rep=mysql_fetch_array($reply)) {
                                $usuario2 = mysql_query("SELECT * FROM user WHERE id = '".$rep['usuario']."'");
                                $user2 = mysql_fetch_array($usuario2);
                    ?>
   
                </li>               
            </ul>
        </div>   
    </div>
</body>
</html>
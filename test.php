<?php include("template/cabecera.php")?>
<?php
include("administrador/config/bd.php");
$sentenciaSQL=$conexion->prepare("SELECT * FROM movies-_card");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach($listaLibros as $movies){ ?>
<div class="col-md-3">
<div class="card">
<img class="card-img-top" src="./img/<?php echo $movies['imagen'];?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $movies['nombre'];?></h4>
    <h4 class="card-title"><?php echo $movies['valoracion'];?></h4>
    <a name="" id="" class="btn btn-primary" href="info.php" role="button">Ver más</a>
    <a name="" id="" class="btn btn-primary" href="carrito.php" role="button">arrendar</a>
</div>
</div>
</div>
<?php } ?>









<?php include("template/pie.php")?>
<?php
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
<input type="checkbox" id="check">
<nav>
    <a href="adminpage.php" style="text-decoration: none">
        <div class="icon" style="font-family: 'ITC Machine', sans-serif;"><img src="assets/img/icon.png" width="150" height="75" alt="BlockbUSM">Blockb<b style="font-family: 'ITC Machine', sans-serif;color: #005F95;">USM</b><b style="font-family: 'ITC Machine', sans-serif;color: #FF0000;"> ADMIN</b></div>
    </a>

    <div class="search_box">
        <input type="search" placeholder="Search any movie">
        <span class="fa fa-search"></span>
    </div>
    <ol>
        <li><a href="adminpage.php">Home</a></li>
        <li><a href="#">Movies</a></li>
        <li><a href="#">Tops</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <?php if(!empty($user)): ?>
            <li><a href="profile.php"><?= $user['admin_username']; ?></a></li>
            <li><a href="salir.php">Log Out</a></li>
        <?php else: ?>
            <li><a href="adminlogin.php">Login</a></li>
        <?php endif; ?>
    </ol>
    <label for="check" class="bar">
        <span class="fa fa-bars" id="bars"></span>
        <span class="fa fa-times" id ="times"></span>
    </label>
</nav>

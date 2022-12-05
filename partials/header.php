<?php
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
?>


<input type="checkbox" id="check">
<nav>
    <a href="/blockbusm" style="text-decoration: none">
        <div class="icon" style="font-family: 'ITC Machine', sans-serif;"><img src="assets/img/icon.png" width="150" height="75" alt="BlockbUSM">Blockb<b style="font-family: 'ITC Machine', sans-serif;color: #005F95;">USM</b></div>
    </a>

    <form action="buscar.php" style="transform: translateY(25%);" method="POST">
        <div class="search_box">
            <input type="search" placeholder="Search any movie" id="MovieSearch" name="srch">
            <span class="fa fa-search"></span>
        </div>
    </form>
    <ol>
        <li><a href="/blockbusm">Home</a></li>
        <li><a href="#">Movies</a></li>
        <li><a href="#">Tops</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <?php if(!empty($user)): ?>
            <li><a href="profile.php?view=<?php echo $user['id']; ?>"><?= $user['username']; ?></a></li>
            <li><a href="salir.php">Log Out</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="registrar.php">Sign Up</a></li>
        <?php endif; ?>
        
    </ol>
    <label for="check" class="bar">
        <span class="fa fa-bars" id="bars"></span>
        <span class="fa fa-times" id ="times"></span>
    </label>
</nav>

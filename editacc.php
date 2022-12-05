<?php
    session_start();

    require "conexion.php";

    $id = $_GET['edit'];

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

    if (isset($_POST['update_user'])) {
        $username  = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if (!empty($username) && empty($password)) {
            $update = $conexion->prepare("UPDATE users SET username = '$username' WHERE id = $id");
            $profile_update = $update->execute();
            if ($profile_update) {
                $message[] = 'Profile updated successfully';
            } else {
                $message[] = "Couldn't update the profile";
            }
        } elseif (empty($username) && !empty($password)) {
            $update = $conexion->prepare("UPDATE users SET password = '$password' WHERE id = $id");
            $profile_update = $update->execute();
            if ($profile_update) {
                $message[] = 'Profile updated successfully';
            } else {
                $message[] = "Couldn't update the profile";
            }
        } elseif (!empty($username) && !empty($password)) {
            $update = $conexion->prepare("UPDATE users SET username = '$username', password = '$password' WHERE id = $id");
            $profile_update = $update->execute();
            if ($profile_update) {
                $message[] = 'Profile updated successfully';
            } else {
                $message[] = "Couldn't update the profile";
            }
        } else {
            $message[]= 'Please fill the fields';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit account | BlockbUSM</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/a7134cdd83876d9776f7aa08e5411e10?family=ITC+Machine" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/admin_sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <?php require "partials/header.php" ?>
    <?php 
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<span class="message">'.$message.'</span>';
            }
        }    
    ?>
    <div class="container" style="display: flex; flex-direction: row; justify-content: space-around; flex-flow: wrap; align-items: center;">
    
        <div class="admin-movie-form-container centered">
            <?php
                $select = $conexion->prepare("SELECT * FROM users WHERE id = $id");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Edit your account</h3>
                <input type="text" placeholder="Enter new username" value="<?php $row['username'] ?>" name="username" class="box">
                <input type="text" placeholder="Enter new password" value="<?php $row['password'] ?>" name="password" class="box">
                <input type="submit" value="Update user details" name="update_user" class="btn">
                <a class="btn2" href="editacc.php?delete=<?php echo $_SESSION['user_id']; ?>">Delete account</a>
                <a href="profile.php?view=<?php echo $_SESSION['user_id'];?>" class="btn">Go Back</a>
            </form>
            <?php  }; ?>
            
        </div>
    </div>

</body>
</html>
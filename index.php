<?php
    session_start();
    if(isset($_SESSION['logIn']) && ($_SESSION['logIn']==true)){
        header('Location: kalendarzTydzien.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <div class="box">
        <div class="loginPanel">
            <p>Zaloguj się</p>
            <form action="login.php" method="post">
            <input type="text" placeholder="login" name="login">
            <input type="text" placeholder="hasło" name="pass">
            <input type="submit" value="Zaloguj">
            </form> 
            <?php
                if(isset($_SESSION['blad'])){
                    echo $_SESSION['blad'];
                }
            ?>
        </div>
    </div>
</body>

</html>
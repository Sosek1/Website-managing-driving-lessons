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
        
          
            <form action="login.php" method="post" class="loginPanel">
            <p>Zaloguj się</p>
            <input type="text" placeholder="login" name="login">
            <input type="password" placeholder="hasło" name="pass">
            <input type="submit" value="Zaloguj">
            <?php
            if(isset($_SESSION['blad'])){
                echo $_SESSION['blad'];
            }
            ?>
         </form> 
    </div>
</body>

</html>
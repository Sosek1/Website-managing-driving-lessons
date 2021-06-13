<?php
session_start();
require_once "connect.php";
require "admin_functions.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}else{
    if(!$_SESSION['admin']){
        header('Location: kalendarzTydzien.php');
        exit();
    }
}

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con = false;
}else{
    $con = true;
}
if(isset($_POST['kat'])){
    $setkat = $_POST['kat'];
}else{
    $setkat = 0;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - kursanci</title>
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navAdmin">
        <div class="logo">
            <img src="img/MotoLka.svg">
        </div>
        <ul class="list">
            <li><a href="adminJazdy.php">Jazdy</a></li>
            <li><a href="adminKursanci.php">Kursanci</a></li>
            <li><a href="adminUsers.php">Instruktorzy</a></li>
            <li><a href="adminRozliczenia.php">Rozliczenia</a></li>
            <li><a href="adminWpłaty.php">Wpłaty</a></li>
            <li><a href="adminWolne.php">Dni wolne</a></li>
            <li>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>
        <div class="burger">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
        </div>
    </nav>

    <div class="adminH">
        <h1>Kursanci</h1>
        <form method="post">
        <select name="kat" onchange="this.form.submit()">
            <option value ="0" <?php if($setkat==0){echo "selected";}?>>WSZYSTKIE</option>
            <option value ="1" <?php if($setkat==1){echo "selected";}?>>AM</option>
            <option value ="2" <?php if($setkat==2){echo "selected";}?>>A1</option>
            <option value ="3" <?php if($setkat==3){echo "selected";}?>>A2</option>
            <option value ="4" <?php if($setkat==4){echo "selected";}?>>A</option>
            <option value ="5" <?php if($setkat==5){echo "selected";}?>>B</option>
        </select>
        </form>
    </div>
    <div class="adminContainer">
        <div class="adminContainer2">
        <div class="adminPupilsOptions">
                <h2>Imię </h2>
                <h2>Nazwisko</h2>
                <h2>Telefon</h2>
                <h2>Wszystkie Jazdy</h2>
                <h2>Jazdy zrealizowane</h2>
                <h2>Ukończony kurs</h2>
        </div>
            <?if($con){
                
                    if($setkat==0){
                        $zap = 'SELECT * FROM kursanci';
                    }else{
                        $zap = 'SELECT * FROM kursanci WHERE kat ='.$setkat;
                    }

                $kur=$conn->query($zap);
                if(!$kur){}else{
                    $ile=$kur->num_rows;
                    if($ile>0){
                        $i = 0;
                        while($i<$ile){
                            $i++;
                            $kurrow = $kur->fetch_assoc();
                            $idk = $kurrow['id'];
                            $imie = $kurrow['imie'];
                            $nazw = $kurrow['surname'];
                            $tel = $kurrow['nrtel'];
                            $uko = $kurrow['ukonczono'];
                            $zap = 'SELECT id FROM rozliczeniaJazd WHERE id_kursanta = '.$idk.' AND zrealizowano = 1';
                            $jazdyn=$conn->query($zap);
                            if(!$jazdyn){}else{
                                $ilejn=$jazdyn->num_rows;
                            }
                            $zap = 'SELECT id FROM jazdy WHERE id_kursanta = '.$idk;
                            $jazdy=$conn->query($zap);
                            if(!$jazdy){}else{
                                $ilej=$jazdy->num_rows;
                            }
                            writekursant($imie, $nazw, $tel, $ilej, $ilejn, $uko);
                        }
                    }else{
                        echo '<h1> BRAK KURSANTÓW </h1>';
                    }
                }
            }
            
            ?>
        </div>
    </div>
    <div class="addUserBtn">
        <a class="btn" href="#">Dodaj</a>
    </div>
    <script src="menu.js"></script>
</body>

</html>
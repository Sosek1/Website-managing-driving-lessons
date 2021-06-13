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
if(isset($_POST['sort'])){
$sort = $_POST['sort'];
}else{
    $sort = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - jazdy</title>
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
                <a href=" logout.php"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>
        <div class="burger">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
        </div>
    </nav>

    <div class="adminH">
        <h1>Jazdy</h1>
        <form method="post">
        <select name="sort" onchange="this.form.submit()">
            <option value ="0" <?php if($sort==0){echo "selected";}?>>Od najnowszych</option>
            <option value ="1" <?php if($sort==1){echo "selected";}?>>Od najstarszych</option>
        </select>
        </form>
    </div>
    <div class="adminContainer">
        <div class="adminContainer2">
            <div class="adminJazdyOptions">
                <h2>Kursant</h2>
                <h2>Instruktor</h2>
                <h2>Data</h2>
                <h2>Godzina</h2>
                <h2>Miejsce</h2>
                <h2>Pojazd</h2>
            </div>
            <?php
if($con){
    
        if($sort==0){
            $zap = 'SELECT * FROM jazdy ORDER BY data_jazdy DESC LIMIT 25';
        }else{
            $zap = 'SELECT * FROM jazdy ORDER BY data_jazdy ASC LIMIT 25';
        }

    $jaz=$conn->query($zap);
    if(!$jaz){}else{
        $ile=$jaz->num_rows;
        if($ile>0){
            $i = 0;
            while($i<$ile){
                $i++;
                $jazrow = $jaz->fetch_assoc();
                $idi = $jazrow['id_instruktora'];
                $idk = $jazrow['id_kursanta'];
                $idp = $jazrow['id_pojazdu'];
                $data = $jazrow['data_jazdy'];
                $miejsce = $jazrow['miejsce'];
                $zap2 = 'SELECT name,surname FROM uzytkownicy WHERE id = '.$idi.'';
                $insdyn=$conn->query($zap2);
                if(!$insdyn){}else{
                    $ileins=$insdyn->num_rows;
                    if($ileins==1){
                        $insrow=$insdyn->fetch_assoc();
                        $insname = $insrow['name'];
                        $inssurname = $insrow['surname'];
                    }
                }
                $zap3 = 'SELECT fullname FROM kursanci WHERE id = '.$idk;
                $kurs=$conn->query($zap3);
                if(!$kurs){}else{
                    $ilekur=$kurs->num_rows;
                    if($ilekur==1){
                        $kursrow = $kurs->fetch_assoc();
                        $kusant_imie = $kursrow['fullname'];
                    }
                }
                $zap4 = 'SELECT nazwa,rejestracja FROM pojazdy WHERE id = '.$idp;
                $poj=$conn->query($zap4);
                if(!$poj){}else{
                    $ilekur=$poj->num_rows;
                    if($ilekur==1){
                        $pojrow = $poj->fetch_assoc();
                        $pojazd_imie = $pojrow['nazwa'];
                        $pojazd_rejestracja = $pojrow['rejestracja'];
                    }
                }
                writejazda($kusant_imie, $insname, $inssurname, $data, $miejsce, $pojazd_imie, $pojazd_rejestracja);
            }
        }
    }
}
?>
            
            
        </div>
    </div>
    <script src="menu.js"></script>
</body>

</html>
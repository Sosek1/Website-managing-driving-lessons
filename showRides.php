<?php
session_start();
require_once "connect.php";
require "functions.php";

if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
if(isset($_GET['id'])){
    $idk = $_GET['id'];
}

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){}else{
    $zap = 'SELECT * FROM kursanci WHERE id = '.$idk;
    $osoba=$conn->query($zap);
    if(!$osoba){
    }else{
        $ile = $osoba->num_rows;
        if($ile>0){
            $osobarow = $osoba -> fetch_assoc();
            $name = $osobarow['fullname'];
            $kat = $osobarow['kat'];
        }
    }
    $con = true;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jazdy</title>
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
</head>

<body>
<nav class="topbar">
        <a href="kalendarzTydzien.php" class="logo">
            <img src="css/MotoLka.png" alt="motoelka logo">
        </a>
        <ul class="menu">
            <li>
                <a href="_szukaj.scss">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <div class="listContainer">
        <h1 class="name3"><?php echo $name.' Kategoria: '.retkat($kat);?></h1>
        <ol class="rideList">
        <?php
            if($con){
                $zap = 'SELECT data_jazdy, id FROM jazdy WHERE id_kursanta = '.$idk;
                $jazda=$conn->query($zap);
                if(!$jazda){
                }else{
                    $ile = $jazda->num_rows;
                    if($ile>0){
                        $i = 0;
                        while ($i < $ile){
                            $jazdarow = $jazda -> fetch_assoc();
                            $godz = $jazdarow['data_jazdy'];
                            $idj = $jazdarow['id'];
                            $data = strtotime($godz);
                            $godz = date('H:00', $data);
                            $data = date("d.m.y", $data);
                            echo '<li><p clas="date3">Data:  <span> '.$data.'</span></p><p class="hour3">Godzina:  <span> '.$godz.'</span></p>';
                            echo '<a href=info.php?id='.$idj.'>Zobacz wiecej</a></li>';
                            $i++;
                        }
                        
                    }
                }
            }


        ?>
        </ol>
    </div>
    <a href="kalendarzTydzien.php" class="backToCalendar">
        <i class="fas fa-calendar-day"></i>
    </a>
</body>

</html>
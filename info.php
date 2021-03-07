<?php
session_start();
require_once "connect.php";
require "functions.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
$idu = $_SESSION['id'];
if(isset($_GET['id'])){
    $idj = $_GET['id'];
}

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){}else{
    $zap = 'SELECT * FROM jazdy WHERE id = '.$idj;
    $rezu=$conn->query($zap);
    if(!$rezu){
    }else{
        $ile = $rezu->num_rows;
        if($ile>0){
            $jazdarow = $rezu->fetch_assoc();
            $ido = $jazdarow['id_kursanta'];
            $idp = $jazdarow['id_pojazdu'];
            $godz = $jazdarow['data_jazdy'];
            $miejsce = $jazdarow['miejsce'];
            $info = $jazdarow['info'];
            $zap = 'SELECT * FROM kursanci WHERE id = '.$ido;
            $osoba=$conn->query($zap);
            if(!$osoba){
            }else{
                $ile = $osoba->num_rows;
                if($ile>0){
                    $osobarow = $osoba->fetch_assoc();
                    $imie = $osobarow['imie'];
                    $nazwisko = $osobarow['surname'];
                    $nrtel = $osobarow['nrtel'];
                    $kat = $osobarow['kat'];
                }
            }
            $zap = 'SELECT * FROM pojazdy WHERE id = '.$idp;
            $pojazd=$conn->query($zap);
            if(!$pojazd){
            }else{
                $ile = $pojazd->num_rows;
                if($ile>0){
                    $pojazdrow = $pojazd->fetch_assoc();
                    $pojname = $pojazdrow['nazwa'];
                    $pojres = $pojazdrow['rejestracja'];
                }
            }
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacje</title>
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <div class="logo">
            <img src="css/MotoLka.png">
        </div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.php">Panel jazd</a></li>
            <li><a href="panelRozliczania.php">Rozliczenie jazdy</a></li>
            <li><a href="szukaj.php">Szukaj</a></li>
            <i class="fas fa-sign-out-alt"></i>
            </a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <h1 class="info2">Informacje o jezdzie</h1>
    <form class="informationContainer">
        <textarea class="name2"><?php echo $imie;?></textarea>
        <textarea class="surname"><?php echo $nazwisko;?></textarea>
        <textarea class="phoneNumber"><?php echo $nrtel;?></textarea>
        <textarea class="category"><?php echo retkat($kat);?></textarea>
        <textarea class="place"><?php echo retplace($miejsce);?></textarea>
        <textarea class="motorcycle"><?php echo $pojname.' | '.$pojres;?></textarea>
        <textarea class="additionalInfo"><?php echo $info;?></textarea>
        <a href="mod.php?id=<?php echo $idj;?>" class="edit">Edytuj</a>
        <a href="delete.php?id=<?php echo $idj;?>" class="delete">Usuń</a>
        <?php //<a href="#" class="addDouble">Dodaj dublet</a> ?>
    </form>
    <a href="kalendarzTydzien.php" class="backToCalendar">
        <i class="fas fa-calendar-day"></i>
    </a>
    <script src="burger.js"></script>
</body>

</html>
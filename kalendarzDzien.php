<?php
session_start();
require_once "connect.php";
require "functions.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}

if(isset($_GET['date'])==true){
    $dzien = $_GET['date'];
}else{
    if($_SESSION['comove']==false){
        unset($_SESSION['move']);
        $_SESSION['comove']=true;
    }else{
        if(isset($_GET['move'])==true){
            if($_GET['move']==0){
                $_SESSION['moveweek']=$_SESSION['moveweek']-1;
                }else if($_GET['move']==1){
                    unset($_SESSION['moveweek']);
                }else if($_GET['move']==2){
                    $_SESSION['moveweek']=$_SESSION['moveweek']+1;
                }

        }
    }
    $dzien=strtotime("now");
    if(isset($_SESSION['moveweek'])){
        $moved = 0;
        if($_SESSION['moveweek']>0){
            while($_SESSION['moveweek']>$moved){
                $dzien=strtotime("+1 day", $dzien);
                $moved++;
            }
        }else{
            while($_SESSION['moveweek']<$moved){
                $dzien=strtotime("-1 day", $dzien);
                $moved--;
            }
        }
    }
}
$day = date('d', $dzien);
$msc = date('m', $dzien);
$ye = date('y', $dzien);
$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con=false;
}else{
    $con=true;
}
$rozliczono = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
    <title>Kalendarz - dzień</title>
    <link rel="stylesheet" href="./css/main.css">
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
            <li><a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            </a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <h1 class="name">Cześć, <?php echo $_SESSION['user_name'];?></h1>
    <a href="kalendarzTydzien.php"><button class="dayWeek">Tydzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <a href="kalendarzDzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <a class="date3" href="kalendarzDzien.php?move=1"><?php echo date("d.M", $dzien);?></a>
        <div class="next">
            <a href="kalendarzDzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="dayContainer">
        <?php 
            $imie;
            $nazwisko;
            $kat;
            if($con){
                $i = 5;
                $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, $msc, $day, $ye));
                $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" AND data_jazdy<"'.$dzk.'" and id_instruktora='.$id.' ORDER BY data_jazdy, dublet ASC';
                $rezu=$conn->query($zap);
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    $i = 5;
                    $ill = 0;
                    $ppp = 0;
                    if($ile > 0){
                        while ($ill < $ile){
                            $jazdarow = $rezu->fetch_assoc();
                            $g = $jazdarow['data_jazdy'];  
                            $idk = $jazdarow['id_kursanta'];
                            $idj = $jazdarow['id'];
                            $dublet = $jazdarow['dublet'];
                            $miejsce = $jazdarow['miejsce'];
                            if($miejsce==2){
                                $czydublet = true;
                            }else{
                                $czydublet = false;
                            }
                            $zap = 'SELECT * FROM kursanci WHERE id='.$idk.'';
                            $osoba=$conn->query($zap);
                            if(!$osoba){
                            }else{
                                $ileo = $osoba->num_rows;
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['imie'];
                                $nazwisko = $osobarow['surname'];
                                $tel = $osobarow['nrtel'];
                                $kat = $osobarow['kat'];
                            }
                            while($i<21){
                                $i++; 
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, $msc, $day, $ye));

                                if($godz == $g){
                                    $last = $godz;
                                    writedzienzosoba($i, $imie, $nazwisko, $kat, $tel, $dzien, $idj, $dublet, $rozliczono, $czydublet);
                                    break;
                                }else if($g == $last){
                                    $i = $i-1;
                                    writedzienzosoba($i, $imie, $nazwisko, $kat, $tel, $dzien, $idj, $dublet, $rozliczono, false);
                                    break;
                                }else{
                                    writedzien($i, $dzien);
                                }
                        
                            }
                            $ill++;
                        }
                    }                        

                    while($i<21){
                        $i++;
                        writedzien($i, $dzien);

                    }
                    
                }
            }



            
        ?>
    </div>

    <div class="settle">Rozlicz</div>

</body>
<script src="burger.js"></script>
<?php
$conn -> close();
?>
</html>

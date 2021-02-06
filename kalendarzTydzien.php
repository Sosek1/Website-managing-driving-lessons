<?php
session_start();
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
if(isset($_GET['move'])==true){
    if($_GET['move']==0){
        $_SESSION['moveweek']=$_SESSION['moveweek']-1;
    }else if($_GET['move']==1){
        unset($_SESSION['moveweek']);
    }else if($_GET['move']==2){
        $_SESSION['moveweek']=$_SESSION['moveweek']+1;
    }
}
$startdate=strtotime("previous Sunday");
$mon=strtotime("+1 day", $startdate);
$tue=strtotime("+2 day", $startdate);
$wen=strtotime("+3 day", $startdate);
$th=strtotime("+4 day", $startdate);
$fr=strtotime("+5 day", $startdate);
$st=strtotime("+6 day", $startdate);
$sd=strtotime("+7 day", $startdate);
if(isset($_SESSION['moveweek'])){
    $moved = 0;
    if($_SESSION['moveweek']>0){
        while($_SESSION['moveweek']>$moved){
            $mon=strtotime("+1 week", $mon);
            $tue=strtotime("+1 week", $tue);
            $wen=strtotime("+1 week", $wen);
            $th=strtotime("+1 week", $th);
            $fr=strtotime("+1 week", $fr);
            $st=strtotime("+1 week", $st);
            $sd=strtotime("+1 week", $sd);
            $moved++;
        }
    }else{
        while($_SESSION['moveweek']<$moved){
            $mon=strtotime("-1 week", $mon);
            $tue=strtotime("-1 week", $tue);
            $wen=strtotime("-1 week", $wen);
            $th=strtotime("-1 week", $th);
            $fr=strtotime("-1 week", $fr);
            $st=strtotime("-1 week", $st);
            $sd=strtotime("-1 week", $sd);
            $moved--;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz - tydzień</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>
    <nav>
        <div class="logo"></div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.html">Panel jazd</a></li>
            <li><a href="panelRozliczania.html">Rozliczenie jazdy</a></li>
            <li><a href="#">Szukaj</a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <h1 class="name">Cześć, <?php echo $_SESSION['user_name'];?>   <a href="logout.php">[Wyloguj się]</a></h1>
    <a href="kalendarzDzien.php"><button class="dayWeek">Dzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <a href="kalendarzTydzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <p class="date3"><a href="kalendarzTydzien.php?move=1"><?php echo date("d.M",$mon)."-".date("d.M",$sd);?></a></p>
        <div class="next">
            <a href="kalendarzTydzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="weekContainer">
        <div class="calendar">
            <div class="record">
                <p>Godzina</p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $mon;?>">Pn</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $tue;?>">Wt</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $wen;?>">Śr</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $th;?>">Czw</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $fr;?>">Pt</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $st;?>">Sb</a></p>
            </div>
            <div class="record">
                <p><a href="kalendarzDzien.php?date=<?php echo $sd;?>">Nd</a></p>
            </div>
            <div class="record">
                <p>6:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>7:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>

            <div class="record">
                <p>8:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>

            <div class="record">
                <p>9:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"> </div>

            <div class="record">
                <p>10:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>11:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>12:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>13:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>14:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>15:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>16:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>17:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>18:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>19:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>20:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>21:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record">
                <p>22:00</p>
            </div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>
            <div class="record"></div>


        </div>
    </div>

    <div class="settle">Rozlicz</div>

</body>

</html>
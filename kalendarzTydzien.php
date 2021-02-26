<?php
session_start();
require_once "connect.php";
require "functions.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
$id = $_SESSION['id'];
if($_SESSION['comove']==true){
    unset($_SESSION['moveweek']);
    $_SESSION['comove']=false;
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
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_errno!=0){echo $conn->connect_error;}else{
    $con = true;
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
        <div class="logo">
        <img src="css/MotoLka.png">
        </div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.php">Panel jazd</a></li>
            <li><a href="rozliczDzien.php">Rozliczenie jazdy</a></li>
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
    <a href="kalendarzDzien.php"><button class="dayWeek">Dzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <a href="kalendarzTydzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <a class="date3" href="kalendarzTydzien.php?move=1">
            <?php echo date("d ",$mon).retmiesiac($mon)." - ".date("d ",$sd).retmiesiac($sd);?></a>
        <div class="next">
            <a href="kalendarzTydzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="weekContainer">
        <div class="hoursContainer">
    
        </div>
        <div class="calendar">
            <div class="record"<?php if(retdayofweek()==1){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}
                ?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $mon;?>">Pn   <?php echo date("d.m", $mon);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==2){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $tue;?>">Wt  <?php echo date("d.m", $tue);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==3){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $wen;?>">Śr  <?php echo date("d.m", $wen);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==4){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $th;?>">Czw  <?php echo date("d.m", $th);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==5){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
               <a class="day" href="kalendarzDzien.php?date=<?php echo $fr;?>">Pt  <?php echo date("d.m", $fr);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==6){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $st;?>">Sb  <?php echo date("d.m", $st);?></a>
            </div>
            <div class="record"<?php if(retdayofweek()==7){echo 'style= "background-color:red"';}else{if($con){
                    $godz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
                    $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$godz.'" and id_instruktora='.$id.'';
                    $rezu=$conn->query($zap);
                    if(!$rezu){}else{$ile = $rezu->num_rows;if($ile>0){echo 'style= "background-color:green"';}}}}?>>
                <a class="day" href="kalendarzDzien.php?date=<?php echo $sd;?>">Nd  <?php echo date("d.m", $sd);?></a>
            </div>
            <?php

                if($con){
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];
                                $miejsce = $dzrow['miejsce'];                   
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
                                    if($godz == $dj){
                                        $pon[] = $i;
                                        if($miejsce == 2 ){$dpon[] = $i;}
                                        
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
                                    if($godz == $dj){
                                        
                                        $wto[] = $i;
                                        if($miejsce == 2 ){$dwto[] = $i;}

                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];                         
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
                                    if($godz == $dj){
                                        $sro[] = $i;
                                        if($miejsce == 2 ){$dsro[] = $i;}
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];                         
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
                                    if($godz == $dj){
                                        $czw[] = $i;
                                        if($miejsce == 2 ){$dczw[] = $i;}
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];                         
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
                                    if($godz == $dj){
                                        $pia[] = $i;
                                        if($miejsce == 2 ){$dpia[] = $i;}
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];                         
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
                                    if($godz == $dj){
                                        $sob[] = $i;
                                        if($miejsce == 2 ){$dsob[] = $i;}
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
                    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
                    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
                    $dzien=$conn->query($zap);
                    if(!$dzien){
                    }else{
                        $iledz = $dzien->num_rows;
                        if($iledz>0){
                            $ilp = 0;
                            while($ilp<$iledz){
                                $i = 6;
                                $dzrow=$dzien->fetch_assoc();
                                $dj = $dzrow['data_jazdy'];                         
                                while($i < 22){
                                    $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
                                    if($godz == $dj){
                                        $nie[] = $i;
                                        if($miejsce == 2 ){$dnie[] = $i;}
                                        break;
                                    }
                                    $i++;
                                }
                                $ilp++;
                            }
                        }else{
                        }
                    }
                    $i=6;
                    $p=0;
                    $w=0;
                    $s=0;
                    $c=0;
                    $pi=0;
                    $so=0;
                    $n=0;
                    $dp=0;
                    $dw=0;
                    $ds=0;
                    $dc=0;
                    $dpi=0;
                    $dso=0;
                    $dn=0;
                    while($i<22){
                        if(isset($pon)){
                            if($pon[$p]==$i){
                                $p++;
                                if($dpon[$dp]==$i){
                                    $dp++;
                                    if($pon[$p]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($mon, $i);
                            }
                        }else{
                            writetydzien($mon, $i);
                        }
                        if(isset($wto)){
                            if($wto[$w]==$i){
                                $w++;
                                if($dwto[$dw]==$i){
                                    $dw++;
                                    if($wto[$w]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($tue, $i);
                            }
                        }else{
                            writetydzien($tue, $i);
                        }
                        if(isset($sro)){
                            if($sro[$s]==$i){
                                $s++;
                                if($dsro[$ds]==$i){
                                    $ds++;
                                    if($sro[$s]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($wen, $i);
                            }
                        }else{
                            writetydzien($wen, $i);
                        }
                        if(isset($czw)){
                            if($czw[$c]==$i){
                                $c++;
                                if($dczw[$dc]==$i){
                                    $dc++;
                                    if($czw[$c]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($th, $i);
                            }
                        }else{
                            writetydzien($th, $i);
                        }
                        if(isset($pia)){
                            if($pia[$pi]==$i){
                                $pi++;
                                if($dpia[$dpi]==$i){
                                    $dp++;
                                    if($pia[$pi]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($fr, $i);
                            }
                        }else{
                            writetydzien($fr, $i);
                        }
                        if(isset($sob)){
                            if($sob[$so]==$i){
                                $so++;
                                if($dsob[$dso]==$i){
                                    $dso++;
                                    if($sob[$so]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($st, $i);
                            }
                        }else{
                            writetydzien($mon, $i);
                        }
                        if(isset($nie)){
                            if($nie[$n]==$i){
                                $n++;
                                if($dnie[$dn]==$i){
                                    $dn++;
                                    if($nie[$n]==$i){
                                        writetydzienznaleziono(); 
                                    }else{
                                        writetydzienznalezionodublet();
                                    }
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien($sd, $i);
                            }
                        }else{
                            writetydzien($sd, $i);
                        }
                    $i++;
                    }
                }?>
                
            </div>
    </div>

    <div class="settle">Rozlicz</div>
    <script src="burger.js"></script>
</body>
<?php
$conn->close();
?>
</html>
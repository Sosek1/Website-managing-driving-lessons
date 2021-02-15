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
/*
$pon[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$wto[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$sro[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$czw[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$pia[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$son[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$nie[16]=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];*/
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
            <?php echo date("d.M",$mon)."-".date("d.M",$sd);?></a>
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
                <a class="day" href="kalendarzDzien.php?date=<?php echo $mon;?>">Pn</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $tue;?>">Wt</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $wen;?>">Śr</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $th;?>">Czw</a>
            </div>
            <div class="record">
               <a class="day" href="kalendarzDzien.php?date=<?php echo $fr;?>">Pt</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $st;?>">Sb</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $sd;?>">Nd</a>
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
                                        if($miejsce == 1 ){$dpon[] = $i;}
                                        
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
                    while($i<22){
                        writegodzina($i);
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
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($wto)){
                            if($wto[$w]==$i){
                                $w++;
                                if($wto[$w]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($sro)){
                            if($sro[$s]==$i){
                                $s++;
                                if($sro[$s]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($czw)){
                            if($czw[$c]==$i){
                                $c++;
                                if($czw[$c]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($pia)){
                            if($pia[$pi]==$i){
                                $pi++;
                                if($pia[$pi]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($sob)){
                            if($sob[$so]==$i){
                                $so++;
                                if($sob[$so]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                        if(isset($nie)){
                            if($nie[$n]==$i){
                                $n++;
                                if($nie[$n]==$i){
                                    writetydzienznalezionodublet();
                                }else{
                                    writetydzienznaleziono();
                                }
                            }else {
                                writetydzien();
                            }
                        }else{
                            writetydzien();
                        }
                    $i++;


/*
                        if($ilewto>0){
                                $wtorow = $wtorek->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
                                if($wtorow['data_jazdy'] == $godz){
                                    $place = $wtorow['miejsce'];
                                    if($place==1){
                                        $wtorow = $wtorek->fetch_assoc();
                                        if($wtorow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }
                        $ilesro = $sroda->num_rows;
                        if($ilesro>0){
                                $srorow = $sroda->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
                                if($srorow['data_jazdy'] == $godz){
                                    $place = $srorow['miejsce'];
                                    if($place==1){
                                        $srorow = $sroda->fetch_assoc();
                                        if($srorow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }
                        $ileczw = $czwartek->num_rows;
                        if($ileczw>0){
                                $czwrow = $czwartek->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
                                if($czwrow['data_jazdy'] == $godz){
                                    $place = $czwrow['miejsce'];
                                    if($place==1){
                                        $czwrow = $czwartek->fetch_assoc();
                                        if($czwrow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }
                        $ilepia = $piatek->num_rows;
                        if($ilepia>0){
                                $piarow = $piatek->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
                                if($piarow['data_jazdy'] == $godz){
                                    $place = $piarow['miejsce'];
                                    if($place==1){
                                        $piarow = $piatek->fetch_assoc();
                                        if($piarow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }
                        $ilesob = $sobota->num_rows;
                        if($ilesob>0){
                                $sobrow = $sobota->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
                                if($sobrow['data_jazdy'] == $godz){
                                    $place = $sobrow['miejsce'];
                                    if($place==1){
                                        $sobrow = $sobota->fetch_assoc();
                                        if($sobrow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }
                        $ileniedz = $niedziela->num_rows;
                        if($ileniedz>0){
                                $niedzrow = $niedziela->fetch_assoc();                            
                                $godz=date("Y-m-d H:i:s", mktime($i, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
                                if($niedzrow['data_jazdy'] == $godz){
                                    $place = $niedzrow['miejsce'];
                                    if($place==1){
                                        $niedzrow = $niedziela->fetch_assoc();
                                        if($niedzrow['data_jazdy'] == $godz){
                                            writetydzienznaleziono();
                                        }else{
                                            writetydzienznalezionodublet();
                                        }
                                    }else{
                                        writetydzienznaleziono();
                                    }
                                }else{
                                    writetydzien();
                                }
                        }else{
                            writetydzien();
                        }*/
                    }
                }


            ?>
            <?php /*<div class="record">
                <p>6:00</p>
            </div>

            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
                <div class="dublet"></div>
                <div class="dublet"></div>
            </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php if($czybaza){$zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>
            
            
            <a class="record">
                <p>7:00</p>
            </a>


            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?></a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record">
                <p>8:00</p>
            </a>


            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record">
                <p>9:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record">
                <p>10:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>11:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>12:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>13:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>14:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>15:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>16:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>  
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>17:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>18:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>19:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>20:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>21:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            */?>
            </div>
    </div>

    <div class="settle">Rozlicz</div>

</body>
<?php
$conn->close();
?>
</html>